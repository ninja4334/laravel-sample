<?php

namespace App\Repositories\Eloquent;

use App\Models\AppType;
use App\Repositories\Contracts\AppTypeRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class AppTypeRepository extends BaseRepository implements AppTypeRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return AppType::class;
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
