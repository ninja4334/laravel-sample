<?php

namespace App\Repositories\Eloquent;

use App\Models\AppCertificate;
use App\Repositories\Contracts\AppCertificateRepositoryContract;
use DB;
use Exception;
use Freevital\Repository\Eloquent\BaseRepository;

class AppCertificateRepository extends BaseRepository implements AppCertificateRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return AppCertificate::class;
    }

    /**
     * {@inheritdoc}
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        DB::beginTransaction();

        try {
            $model = $this->query->firstOrNew($attributes);
            $model->fill($values);
            if (!$model->exists) {
                $model->app_id = $values['app_id'];
            }
            $model->save();

            // Sync a signet media file
            if ($media_id = array_get($values, 'signet_file_id')) {
                $model->syncMedia($media_id, AppCertificate::MEDIA_SIGNET);
            }

            // Sync a signature media file
            if ($media_id = array_get($values, 'signature_file_id')) {
                $model->syncMedia($media_id, AppCertificate::MEDIA_SIGNATURE);
            }

            // Sync a certificate media file
            if ($media_id = array_get($values, 'certificate_file_id')) {
                $model->syncMedia($media_id, AppCertificate::MEDIA_CERTIFICATE);
            }

            DB::commit();

            return $model;
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * Get the signet file of certificate.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getSignetFile(int $id)
    {
        $model = $this->query
            ->withMedia(AppCertificate::MEDIA_SIGNET)
            ->where('app_id', $id)
            ->first(['app_id']);

        if ($model) {
            return $model->getAttribute('signet_file');
        }

        return null;
    }

    /**
     * Get the signature file of certificate.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getSignatureFile(int $id)
    {
        $model = $this->query
            ->withMedia(AppCertificate::MEDIA_SIGNATURE)
            ->where('app_id', $id)
            ->first(['app_id']);

        if ($model) {
            return $model->getAttribute('signature_file');
        }

        return null;
    }

    /**
     * Detach a certificate file of application.
     *
     * @param int $file_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachCertificateFile(int $file_id, int $id)
    {
        $model = $this->query->find($id);

        if ($model) {
            return $model->media()->where('id', $file_id)->delete();
        }

        return false;
    }
}
