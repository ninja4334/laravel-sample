<?php

namespace App\Repositories\Eloquent;

use App\Models\AppNotification;
use App\Repositories\Contracts\AppNotificationRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class AppNotificationRepository extends BaseRepository implements AppNotificationRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return AppNotification::class;
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
        $appNotification = new AppNotification();
        $attributes['date'] = $appNotification->getDateAttribute(array_get($attributes, 'date'));

        $model = $this->model->newInstance();
        $model->fill($attributes);
        $model->type_id = $attributes['type_id'];
        $model->save();

        return $model;
    }

    /**
     * Create a new entity.
     *
     * @param array $attributes
     * @param int $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $appNotification = new AppNotification();
        $attributes['date'] = $appNotification->getDateAttribute(array_get($attributes, 'date'));

        return parent::update($attributes, $id);
    }
}
