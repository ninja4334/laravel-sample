<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class UserCriteria implements CriteriaContract
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
        if ($value = array_get($this->params, 'board_id')) {
            $query->byBoardId($value);
        }

        if ($value = array_get($this->params, 'app_id')) {
            $query->byAppId($value);
        }

        if ($value = array_get($this->params, 'role')) {
            $query->byRoleName($value);
        }

        if ($value = array_get($this->params, 'without_role')) {
            $query->withoutRoleName($value);
        }

        if (array_get($this->params, 'without_system')) {
            $query->whereHas('roles', function (Builder $query) {
                return $query->withoutSystemRole();
            });
        }

        if ($value = array_get($this->params, 'name')) {
            $sqlRaw = 'CONCAT_WS(" ",first_name,last_name) LIKE "%' . $value . '%"';
            $query->whereRaw($sqlRaw);
        }

        if ($value = array_get($this->params, 'email')) {
            $query->where('email', 'LIKE', "%$value%");
        }

        if ($value = array_get($this->params, 'emails')) {
            $query->whereIn('email', $value);
        }

        if ($value = array_get($this->params, 'password')) {
            $query->where('password', bcrypt($value));
        }

        if ($value = array_get($this->params, 'created_at')) {
            $query->whereDate('created_at', $value);
        }

        return $query;
    }
}
