<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class WithSubmissionRelationsCriteria implements CriteriaContract
{
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
            'app' => function ($query) {
                return $query
                    ->with(['activity', 'type', 'profession', 'users'])
                    ->withCount('documents', 'requirements')
                    ->withTrashed();
            },
            'status',
            'type',
            'reviewers',
            'e_signature',
            'user' => function ($query) {
                return $query->withTrashed();
            }
        ]);
    }
}
