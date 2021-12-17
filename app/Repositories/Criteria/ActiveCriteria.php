<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class ActiveCriteria implements CriteriaContract
{
    /**
     * @var bool
     */
    protected $is_active;

    /**
     * @param bool $is_active
     */
    public function __construct(bool $is_active = true)
    {
        $this->is_active = $is_active;
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
        return $query->where('is_active', $this->is_active);
    }
}
