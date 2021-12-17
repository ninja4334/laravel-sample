<?php

namespace App\Repositories\Criteria;

use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class SubmissionCriteria implements CriteriaContract
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param Builder            $query
     * @param RepositoryContract $repository
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $query, RepositoryContract $repository): Builder
    {
        $query->has('user');

        if ($value = array_get($this->params, 'board_id')) {
            $table = $query->getModel()->getTable();

            $query->where($table . '.board_id', $value);
        }

        if ($value = array_get($this->params, 'app_id')) {
            $query->where('app_id', $value);
        }

        if ($value = array_get($this->params, 'type_id')) {
            $query->whereHas('app', function ($query) use ($value) {
                return $query->where('type_id', $value);
            });
        }

        if ($value = array_get($this->params, 'status_id')) {
            $query->where('status_id', $value);
        }

        if ($value = array_get($this->params, 'status')) {
            $query->whereHas('status', function ($query) use ($value) {
                return $query->where('system_name', $value);
            });
        }

        if ($value = array_get($this->params, 'user_id')) {
            $query->where('user_id', $value);
        }

        if ($value = array_get($this->params, 'reviewer_id')) {
            $query
                ->whereHas('app.users', function ($query) use ($value) {
                    return $query->where('id', $value);
                })
                ->where(function ($query) use ($value) {
                    $query
                        ->doesntHave('reviewers')
                        ->orWhereHas('reviewers', function ($query) use ($value) {
                            $query->where('user_id', $value);
                        });
                })
            ;
        }

        if ($value = array_get($this->params, 'name')) {
            $query->where(function ($query) use ($value) {
                $query
                    ->whereHas('type', function ($query) use ($value) {
                        return $query->where('name', 'like', '%' . $value . '%');
                    })
                    ->orWhereHas('app.type', function ($query) use ($value) {
                        return $query->where('name', 'like', '%' . $value . '%');
                    });
            });

        }

        if (array_get($this->params, 'date_start') && array_get($this->params, 'date_end')) {
            $field = 'submitted_at';

            if (array_get($this->params, 'status') === 'approved') {
                $field = 'approved_at';
            }

            $query->whereBetween($field, [
                Carbon::parse($this->params['date_start'])->startOfDay(),
                Carbon::parse($this->params['date_end'])->endOfDay()
            ]);
        }

        if ($value = array_get($this->params, 'percentages')) {
            $totalCount = $query->count();
            $count = $totalCount * $value / 100;
            $count = (int)round($count);
            $query->limit($count ? $count : 1);
        }

        if (array_get($this->params, 'with_custom')) {
            $query->where(function ($query) {
                $query
                    ->where(function ($query) {
                        return $query->whereNotNull('status_id');
                    })
                    ->orWhere(function ($query) {
                        return $query
                            ->whereNull('status_id')
                            ->whereNull('app_id');
                    });
            });
        } else if (array_has($this->params, 'submitted') && !is_null($this->params['submitted'])) {
            if ($this->params['submitted']) {
                $query
                    ->whereNotNull('app_id')
                    ->whereNotNull('status_id');
            } else {
                $query
                    ->whereNotNull('app_id')
                    ->whereNull('status_id');
            }
        }

        if (array_has($this->params, 'lapsed') && !is_null($this->params['lapsed'])) {
            $operator = $this->params['lapsed'] ? '>=' : '<';

            $query
                ->select(['submissions.*', 'apps.id'])
                ->leftJoin('apps', 'submissions.app_id', '=', 'apps.id');

            $query->whereNested(function ($query) use ($operator) {

                // By app renewal date
                $query->where(function ($query) use ($operator) {
                    return $query
                        ->whereNotNull('submissions.app_id')
                        ->whereNotNull('apps.renewal_date')
                        ->whereNotNull('submissions.approved_at')
                        ->whereRaw('submissions.approved_at ' . $operator . ' DATE(apps.renewal_date)');
                });

                // By app renewal date
                $query->orWhere(function ($query) use ($operator) {
                    return $query
                        ->whereNotNull('submissions.app_id')
                        ->whereNotNull('apps.renewal_date')
                        ->whereNull('submissions.approved_at')
                        ->whereRaw('NOW()' . $operator . ' apps.renewal_date');
                });

                // By app renewal year
                $query->orWhere(function ($query) use ($operator) {
                    return $query
                        ->whereNotNull('submissions.app_id')
                        ->whereNull('apps.renewal_date')
                        ->whereNotNull('apps.renewal_years')
                        ->whereRaw('submissions.approved_at ' . $operator . ' DATE_ADD(submissions.approved_at, INTERVAL apps.renewal_years YEAR)');
                });

                // By submission renewal date
                $query->orWhere(function ($query) use ($operator) {
                    return $query
                        ->whereNull('submissions.app_id')
                        ->whereNotNull('submissions.renewal_date')
                        ->whereRaw('NOW() ' . $operator . 'submissions.renewal_date');
                });

                // Include the incomplete submissions to the query
                if (!$this->params['lapsed']) {
                    $query->orWhere(function ($query) use ($operator) {
                        return $query
                            ->whereNotNull('submissions.app_id')
                            ->whereNull('apps.renewal_date')
                            ->whereNull('submissions.approved_at');
                    });
                }
            });
        }

        return $query;
    }
}
