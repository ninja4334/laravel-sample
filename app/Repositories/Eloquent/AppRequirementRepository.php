<?php

namespace App\Repositories\Eloquent;

use App\Models\AppRequirement;
use App\Repositories\Contracts\AppRequirementRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class AppRequirementRepository extends BaseRepository implements AppRequirementRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return AppRequirement::class;
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
        $model->app_id = $attributes['app_id'];
        $model->save();

        return $model;
    }
}
