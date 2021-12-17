<?php

namespace App\Repositories\Eloquent;

use App\Models\State;
use App\Repositories\Contracts\StateRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class StateRepository extends BaseRepository implements StateRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return State::class;
    }
}
