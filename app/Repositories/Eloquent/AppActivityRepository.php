<?php

namespace App\Repositories\Eloquent;

use App\Models\AppActivity;
use App\Repositories\Contracts\AppActivityRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class AppActivityRepository extends BaseRepository implements AppActivityRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return AppActivity::class;
    }

    /**
     * {@inheritdoc}
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $model = $this->query->firstOrNew($attributes);
        $model->fill($values);
        $model->app_id = $values['app_id'];
        $model->save();

        return $model;
    }
}
