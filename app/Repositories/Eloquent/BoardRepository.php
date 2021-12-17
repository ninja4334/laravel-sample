<?php

namespace App\Repositories\Eloquent;

use App\Models\Board;
use App\Models\BoardProfession;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Contracts\BoardRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class BoardRepository extends BaseRepository implements BoardRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return Board::class;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $attributes)
    {
        $model = parent::create($attributes);

        if ($professions = array_get($attributes, 'professions')) {
            $models = [];
            foreach ($professions as $professionData) {
                $professionModel = new BoardProfession();
                $professionModel->fill($professionData);

                $models[] = $professionModel;
            }

            $model->professions()->saveMany($models);
        }

        return $model;
    }

    /**
     * Update active status.
     *
     * @param bool $status
     * @param int  $id
     *
     * @return mixed
     */
    public function updateStatus(bool $status, int $id)
    {
        $model = $this->find($id);
        $model->is_active = $status;

        return $model->save();
    }

    /**
     * Attach a role to a board.
     *
     * @param string $roleName
     * @param int    $board_id
     * @param array  $perms
     *
     * @return mixed
     */
    public function attachRole(string $roleName, int $board_id, array $perms = [])
    {
        $model = $this->model->find($board_id);

        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return;
        }

        $model->roles()->attach($role->id);

        if (!empty($perms)) {
            foreach ($perms as $perm) {
                $permModel = Permission::where('name', $perm)->firstOrFail();

                $role->perms()->attach($permModel, ['board_id' => $board_id]);
            }
        }

        return $model;
    }
}
