<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Freevital\Repository\Contracts\CriteriaContract;
use Freevital\Repository\Contracts\RepositoryContract;

class ByConfirmationTokenCriteria implements CriteriaContract
{
    /**
     * @var string
     */
    protected $confirmation_token;

    /**
     * @param string $confirmation_token
     */
    public function __construct(string $confirmation_token)
    {
        $this->confirmation_token = $confirmation_token;
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
        return $query->where('confirmation_token', $this->confirmation_token);
    }
}
