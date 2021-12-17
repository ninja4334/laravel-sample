<?php

namespace App\Repositories\Contracts;

use Freevital\Repository\Contracts\RepositoryContract;

interface UserRepositoryContract extends RepositoryContract
{
    /**
     * Create an inactive user with confirmation token.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function createInactiveUser(array $attributes);

    /**
     * Update a user's password by id.
     *
     * @param string $password
     * @param int    $id
     *
     * @return bool
     */
    public function updatePassword(string $password, int $id);

    /**
     * Update a user active status.
     *
     * @param bool $status
     * @param int  $id
     *
     * @return mixed
     */
    public function updateStatus(bool $status, int $id);

    /**
     * Attach a board to a user.
     *
     * @param int   $board_id
     * @param mixed $user
     *
     * @return mixed
     */
    public function attachBoard(int $board_id, $user);

    /**
     * Attach a role to a user.
     *
     * @param string $roleName
     * @param mixed  $user
     *
     * @return mixed
     */
    public function attachRole(string $roleName, $user);

    /**
     * Sync a role with a user.
     *
     * @param string $roleName
     * @param mixed  $user
     *
     * @return mixed
     */
    public function syncRole(string $roleName, $user);
}
