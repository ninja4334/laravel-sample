<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class AppDocument extends Model
{
    use Mediable;

    /**
     * Types of document.
     */
    const TYPE_UPLOAD = 'upload';
    const TYPE_DOWNLOAD = 'download';
    const TYPE_SIGNATURE = 'signature';

    /**
     * Media tags.
     */
    const MEDIA_MAIN = 'main';

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'file'
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'metadata' => 'object'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'type',
        'metadata'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'app_id',
        'media'
    ];

    /**
     * Retrieve application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }

    /**
     * Retrieve submission documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissionDocuments()
    {
        return $this->hasMany(SubmissionDocument::class, 'document_id');
    }

    /**
     * Get the main media file.
     *
     * @return \Plank\Mediable\Media|null
     */
    public function getFileAttribute()
    {
        return $this->firstMedia(self::MEDIA_MAIN);
    }

    /**
     * Get the document types.
     *
     * @return array
     */
    public static function types()
    {
        return [
            self::TYPE_UPLOAD,
            self::TYPE_DOWNLOAD,
            self::TYPE_SIGNATURE
        ];
    }
}
