<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class SystemCriteria implements CriteriaContract
{
    /**
     * @var bool
     */
    protected $is_system;

    /**
     * @param bool $is_system
     */
    public function __construct(bool $is_system = true)
    {
        $this->is_system = $is_system;
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
        return $query->where('is_system', $this->is_system);
    }
}
