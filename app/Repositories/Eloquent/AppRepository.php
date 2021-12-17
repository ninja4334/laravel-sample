<?php

namespace App\Repositories\Eloquent;

use App\Models\App;
use App\Models\AppCertificate;
use App\Models\Media;
use App\Repositories\Contracts\AppRepositoryContract;
use DB;
use Exception;
use Freevital\Repository\Eloquent\BaseRepository;

class AppRepository extends BaseRepository implements AppRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return App::class;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $attributes)
    {
        DB::beginTransaction();

        try {
            $model = $this->model->newInstance();
            $model->fill($attributes);
            $model->board_id = $attributes['board_id'];
            $model->save();

            // Attach pdf file to application
            $model->attachMedia($attributes['media'], 'main');

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
        if (array_get($attributes, 'type_id') == 'none') {
            array_set($attributes, 'type_id', null);
        }

        $app = new App();
        $attributes['renewal_date'] = $app->getRenewalDateAttribute(array_get($attributes, 'renewal_date'));

        return parent::update($attributes, $id);
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
     * Update application settings.
     *
     * @param array $settings
     * @param int $id
     *
     * @return mixed
     */
    public function updateSettings(array $settings, int $id)
    {
        $model = $this->find($id);
        $model->settings = $settings;

        return $model->save();
    }

    /**
     * Update filling stage.
     *
     * @param int $stage
     * @param int $id
     *
     * @return mixed
     */
    public function updateFillingStage(int $stage, int $id)
    {
        $model = $this->model->find($id);

        if ($model->filling_stage <= $stage) {
            $model->filling_stage = $stage;
            $model->save();
        }

        return $model;
    }

    /**
     * Get the approved files of application.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getApprovedFiles(int $id)
    {
        return $this->query
            ->withMedia(App::MEDIA_APPROVED)
            ->where('id', $id)
            ->first(['id'])
            ->getAttribute('approved_files');
    }

    /**
     * Attach a approved file to application.
     *
     * @param Media $media
     * @param int   $id
     *
     * @return mixed
     */
    public function attachApprovedFile(Media $media, int $id)
    {
        $model = $this->query->find($id);

        return $model->attachMedia($media, App::MEDIA_APPROVED);
    }

    /**
     * Detach a approved file of application.
     *
     * @param int $file_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachApprovedFile(int $file_id, int $id)
    {
        $model = $this->query->find($id);

        if ($model) {
            return $model->media()->where('id', $file_id)->delete();
        }

        return false;
    }

    /**
     * Get the required files of application.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getRequiredFiles(int $id)
    {
        return $this->query
            ->withMedia(App::MEDIA_REQUIRED)
            ->where('id', $id)
            ->first(['id'])
            ->getAttribute('required_files');
    }

    /**
     * Attach a required file to application.
     *
     * @param Media $media
     * @param int   $id
     *
     * @return mixed
     */
    public function attachRequiredFile(Media $media, int $id)
    {
        $model = $this->query->find($id);

        return $model->attachMedia($media, App::MEDIA_REQUIRED);
    }

    /**
     * Detach a required file of application.
     *
     * @param int $file_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachRequiredFile(int $file_id, int $id)
    {
        $model = $this->query->find($id);

        if ($model) {
            return $model->media()->where('id', $file_id)->delete();
        }

        return false;
    }

    /**
     * Synchronize a certificate file with an application.
     *
     * @param Media $media
     * @param int   $id
     *
     * @return mixed
     */
    public function syncCertificateFile(Media $media, int $id)
    {
        return $this->syncMedia($id, $media, App::MEDIA_CERTIFICATE);
    }

    /**
     * Attach a user to an application.
     *
     * @param int $user_id
     * @param int $id
     *
     * @return mixed
     */
    public function attachUser(int $user_id, int $id)
    {
        $model = $this->query->find($id);

        return $model->users()->syncWithoutDetaching([$user_id]);
    }

    /**
     * Detach a user from an application.
     *
     * @param int $user_id
     * @param int $id
     *
     * @return mixed
     */
    public function detachUser(int $user_id, int $id)
    {
        $model = $this->query->find($id);

        return $model->users()->detach([$user_id]);
    }
}
