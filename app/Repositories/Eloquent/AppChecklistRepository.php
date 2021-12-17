<?php

namespace App\Repositories\Eloquent;

use App\Models\AppChecklist;
use App\Repositories\Contracts\AppChecklistRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class AppChecklistRepository extends BaseRepository implements AppChecklistRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return AppChecklist::class;
    }

    /**
     * {@inheritdoc}
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
