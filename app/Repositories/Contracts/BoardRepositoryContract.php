<?php

namespace App\Repositories\Contracts;

use Freevital\Repository\Contracts\RepositoryContract;

interface BoardRepositoryContract extends RepositoryContract
{
    /**
     * Update active status.
     *
     * @param bool $status
     * @param int  $id
     *
     * @return mixed
     */
    public function updateStatus(bool $status, int $id);

    /**
     * Attach a role to a board.
     *
     * @param string $roleName
     * @param int    $board_id
     * @param array  $perms
     *
     * @return mixed
     */
    public function attachRole(string $roleName, int $board_id, array $perms = []);
}
