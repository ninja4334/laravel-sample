<?php

namespace App\Repositories\Contracts;

use Freevital\Repository\Contracts\RepositoryContract;

interface AppCertificateRepositoryContract extends RepositoryContract
{
    /**
     * Get the signet file of certificate.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getSignetFile(int $id);

    /**
     * Get the signature file of certificate.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getSignatureFile(int $id);

    /**
     * Detach a certificate file of application.
     *
     * @param int $file_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachCertificateFile(int $file_id, int $id);
}
