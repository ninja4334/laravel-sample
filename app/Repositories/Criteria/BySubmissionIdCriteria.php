<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class BySubmissionIdCriteria implements CriteriaContract
{
    /**
     * @var int
     */
    protected $submission_id;

    /**
     * @param int $submission_id
     */
    public function __construct(int $submission_id)
    {
        $this->submission_id = $submission_id;
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
        return $query->where('submission_id', $this->submission_id);
    }
}
