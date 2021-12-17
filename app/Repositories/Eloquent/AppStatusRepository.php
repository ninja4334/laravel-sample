<?php

namespace App\Repositories\Eloquent;

use App\Models\AppStatus;
use App\Repositories\Contracts\AppStatusRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class AppStatusRepository extends BaseRepository implements AppStatusRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return AppStatus::class;
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
        $model->is_default = false;
        $model->save();

        return $model;
    }
}
