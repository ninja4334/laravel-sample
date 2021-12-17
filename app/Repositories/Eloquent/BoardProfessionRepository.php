<?php

namespace App\Repositories\Eloquent;

use App\Models\BoardProfession;
use App\Repositories\Contracts\BoardProfessionRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class BoardProfessionRepository extends BaseRepository implements BoardProfessionRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return BoardProfession::class;
    }

    /**
     * Create a new entity.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = $this->model->newInstance();
        $model->fill($attributes);
        $model->board_id = $attributes['board_id'];
        $model->save();

        return $model;
    }
}
