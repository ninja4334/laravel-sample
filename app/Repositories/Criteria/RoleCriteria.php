<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class RoleCriteria implements CriteriaContract
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
        if (array_get($this->params, 'without_member')) {
            $query->withoutMember();
        }

        if (array_get($this->params, 'without_system_role')) {
            $query->withoutSystemRole();
        }

        return $query;
    }
}
