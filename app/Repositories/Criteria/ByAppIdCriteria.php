<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class ByAppIdCriteria implements CriteriaContract
{
    /**
     * @var int
     */
    protected $app_id;

    /**
     * @param int $app_id
     */
    public function __construct(int $app_id)
    {
        $this->app_id = $app_id;
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
        return $query->where('app_id', $this->app_id);
    }
}
