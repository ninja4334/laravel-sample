<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class WithRoleRelationsCriteria implements CriteriaContract
{
    /**
     * @var int
     */
    protected $board_id;

    /**
     * @param int $board_id
     */
    public function __construct(int $board_id)
    {
        $this->board_id = $board_id;
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
        return $query->with([
            'perms' => function ($query) {
                return $query->wherePivot('board_id', $this->board_id);
            }
        ]);
    }
}
