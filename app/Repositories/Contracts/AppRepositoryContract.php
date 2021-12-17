<?php

namespace App\Repositories\Contracts;

use App\Models\Media;
use Freevital\Repository\Contracts\RepositoryContract;

interface AppRepositoryContract extends RepositoryContract
{
    /**
     * Update active status.
     *
     * @param bool $status
     * @param int $id
     *
     * @return mixed
     */
    public function updateStatus(bool $status, int $id);

    /**
     * Update application settings.
     *
     * @param array $settings
     * @param int $id
     *
     * @return mixed
     */
    public function updateSettings(array $settings, int $id);

    /**
     * Update filling stage.
     *
     * @param int $stage
     * @param int $id
     *
     * @return mixed
     */
    public function updateFillingStage(int $stage, int $id);

    /**
     * Get the approved files of application.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getApprovedFiles(int $id);

    /**
     * Attach an approved file to application.
     *
     * @param Media $media
     * @param int $id
     *
     * @return mixed
     */
    public function attachApprovedFile(Media $media, int $id);

    /**
     * Detach an approved file of application.
     *
     * @param int $file_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachApprovedFile(int $file_id, int $id);

    /**
     * Get the required files of application.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getRequiredFiles(int $id);

    /**
     * Attach a required file to application.
     *
     * @param Media $media
     * @param int $id
     *
     * @return mixed
     */
    public function attachRequiredFile(Media $media, int $id);

    /**
     * Detach a required file of application.
     *
     * @param int $file_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachRequiredFile(int $file_id, int $id);

    /**
     * Synchronize a certificate file with an application.
     *
     * @param Media $media
     * @param int $id
     *
     * @return mixed
     */
    public function syncCertificateFile(Media $media, int $id);

    /**
     * Attach a user to an application.
     *
     * @param int $user_id
     * @param int $id
     *
     * @return mixed
     */
    public function attachUser(int $user_id, int $id);

    /**
     * Detach a user from an application.
     *
     * @param int $user_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachUser(int $user_id, int $id);
}
