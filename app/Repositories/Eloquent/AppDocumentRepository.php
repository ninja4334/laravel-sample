<?php

namespace App\Repositories\Eloquent;

use App\Models\AppDocument;
use App\Repositories\Contracts\AppDocumentRepositoryContract;
use DB;
use Freevital\Repository\Eloquent\BaseRepository;

class AppDocumentRepository extends BaseRepository implements AppDocumentRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return AppDocument::class;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $attributes)
    {
        DB::beginTransaction();

        try {
            // Create an entity
            $model = $this->model->newInstance();
            $model->fill($attributes);
            $model->app_id = $attributes['app_id'];
            $model->save();

            // Attach a media
            if ($model->type != AppDocument::TYPE_UPLOAD && array_get($attributes, 'media_id')) {
                $model->attachMedia($attributes['media_id'], AppDocument::MEDIA_MAIN);
            }

            DB::commit();

            return $model;
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $attributes, $id)
    {
        DB::beginTransaction();

        try {
            $this->applyScope();
            $model = $this->model->findOrFail($id);

            $oldTypeAttribute = $model->getAttribute('type');

            $model->fill($attributes);
            $model->save();

            // Sync a media
            if ($model->type != AppDocument::TYPE_UPLOAD && array_get($attributes, 'media_id')) {
                $model->syncMedia($attributes['media_id'], AppDocument::MEDIA_MAIN);
            }

            // If type has been changed detach a file
            if ($model->type == AppDocument::TYPE_UPLOAD && $model->type != $oldTypeAttribute) {
                $model->detachMediaTags(AppDocument::MEDIA_MAIN);
            }

            DB::commit();

            return $model;
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
