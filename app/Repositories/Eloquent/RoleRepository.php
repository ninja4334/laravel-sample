<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryContract;
use DB;
use Freevital\Repository\Eloquent\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Role::class;
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
        $permissions = (array) array_get($attributes, 'permissions');
        $board_id = array_get($attributes, 'board_id');

        DB::beginTransaction();

        try {
            // Create a role
            $model = parent::create($attributes);

            // Attach the permissions to a role
            $model->perms()->attach($permissions, compact('board_id'));

            // Attach a board to a role
            if ($board_id) {
                $model->boards()->attach($board_id);
            }

            DB::commit();

            return $model;
        } catch (Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    /**
     * Update an entity by id.
     *
     * @param array $attributes
     * @param int   $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $permissions = (array) array_get($attributes, 'permissions');
        $board_id = array_get($attributes, 'board_id');

        DB::beginTransaction();

        try {
            // Update a role
            $model = $this->query->findOrFail($id);
            if (!$model->is_system) {
                $model->fill($attributes);
                $model->save();
            }

            // Sync the permissions
            $model->perms()->wherePivot('board_id', $board_id)->detach();
            $model->perms()->attach($permissions, compact('board_id'));

            DB::commit();

            return $model;
        } catch (Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }
}
