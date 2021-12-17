<?php

namespace App\Services;

use App\Repositories\Contracts\SettingsRepositoryContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SettingsService
{
    /**
     * @var SettingsRepositoryContract
     */
    protected $settingsRepository;

    /**
     * @param SettingsRepositoryContract $settingsRepository
     */
    public function __construct(SettingsRepositoryContract $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * TODO: need to comment
     *
     * @param string|array $attributes
     *
     * @return mixed
     */
    public function get($attributes)
    {
        if (is_array($attributes)) {
            return $this->getItems($attributes);
        }

        return $this->getSingleItem($attributes);
    }

    /**
     * TODO: need to comment
     *
     * @param $attributes
     *
     * @return mixed
     */
    protected function getItems($attributes)
    {
        return $this->settingsRepository
            ->scopeQuery(function ($query) use ($attributes) {
                return $query->whereIn('name', $attributes);
            })
            ->pluck('value', 'name');
    }

    /**
     * TODO: need to comment
     *
     * @param $attribute
     *
     * @return mixed
     */
    protected function getSingleItem($attribute)
    {
        $model = $this->settingsRepository
            ->scopeQuery(function ($query) use ($attribute) {
                return $query->where('name', $attribute);
            })
            ->first(['value']);

        if (!$model) {
            throw new ModelNotFoundException();
        }

        return $model->value;
    }
}