<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use DB;
use Freevital\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
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
        DB::beginTransaction();

        try {
            $model = $this->model->newInstance();
            $model->fill($attributes);
            $model->is_active = true;
            $model->save();

            // Attach user to a role
            if ($roleName = array_get($attributes, 'role.name')) {
                $this->attachRole($roleName, $model);
            }

            // Attach user to a board
            if ($board_id = array_get($attributes, 'board_id')) {
                $this->attachBoard($board_id, $model);
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
        DB::beginTransaction();

        try {
            // Update an entity
            $model = parent::update($attributes, $id);

            // Attach user to a role
            if ($roleName = array_get($attributes, 'role.name')) {
                if ($model->hasRole('reviewer') && $roleName != 'reviewer') {
                    $model->apps()->detach();
                }
                $this->syncRole($roleName, $model);
            }

            DB::commit();

            return $model;
        } catch (Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    /**
     * Create an inactive user with confirmation token.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function createInactiveUser(array $attributes)
    {
        $model = $this->model->newInstance();
        $model->fill($attributes);
        $model->is_active = false;
        $model->confirmation_token = str_random(32);
        $model->save();

        return $model;
    }

    /**
     * Update a user's password by id.
     *
     * @param string $password
     * @param int    $id
     *
     * @return bool
     */
    public function updatePassword(string $password, int $id)
    {
        $model = $this->find($id);
        $model->password = $password;

        return $model->save();
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
     * Attach a board to a user.
     *
     * @param int   $board_id
     * @param mixed $user
     *
     * @return mixed
     */
    public function attachBoard(int $board_id, $user)
    {
        if (!($user instanceof User) && is_int($user)) {
            $user = $this->model->find($user);
        }

        return $user->boards()->attach($board_id);
    }

    /**
     * Attach a role to a user.
     *
     * @param string $roleName
     * @param mixed  $user
     *
     * @return mixed
     */
    public function attachRole(string $roleName, $user)
    {
        if (!($user instanceof User) && is_int($user)) {
            $user = $this->model->find($user);
        }

        $role = Role::where('name', $roleName)->first();

        return $user->roles()->attach($role->id);
    }

    /**
     * Sync a role with a user.
     *
     * @param string $roleName
     * @param mixed  $user
     *
     * @return mixed
     */
    public function syncRole(string $roleName, $user)
    {
        if (!($user instanceof User) && is_int($user)) {
            $user = $this->model->find($user);
        }

        $role = Role::where('name', $roleName)->first();

        return $user->roles()->sync([$role->id]);
    }
}
