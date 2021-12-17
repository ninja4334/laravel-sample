<?php

namespace App\Repositories\Eloquent;

use App\Models\Settings;
use App\Repositories\Contracts\SettingsRepositoryContract;
use DB;
use Freevital\Repository\Eloquent\BaseRepository;

class SettingsRepository extends BaseRepository implements SettingsRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Settings::class;
    }

    /**
     * Update all entities by key.
     *
     * @param array  $data
     * @param string $keyColumn
     *
     * @return mixed
     */
    public function updateAllByKey(array $data, string $keyColumn)
    {
        DB::beginTransaction();

        try {
            foreach ($data as $key => $value) {
                $model = $this->model->where($keyColumn, $key)->firstOrFail();
                $model->value = $value;
                $model->save();
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }
}
