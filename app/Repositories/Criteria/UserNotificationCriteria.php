<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class UserNotificationCriteria implements CriteriaContract
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
        if ($value = array_get($this->params, 'type_ids')) {
            $query->whereHas('submissions', function (Builder $query) use ($value) {
                return $query
                    ->whereIn('type_id', $value)
                    ->orWhereHas('app', function (Builder $query) use ($value) {
                        return $query->whereIn('type_id', $value);
                    });
            });
    }

        return $query;
    }
}
