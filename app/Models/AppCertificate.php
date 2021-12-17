<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class AppCertificate extends Model
{
    use Mediable;

    /**
     * Media tags.
     */
    const MEDIA_SIGNET = 'signet';
    const MEDIA_SIGNATURE = 'signature';
    const MEDIA_CERTIFICATE = 'certificate';

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'signet_file',
        'signature_file',
        'certificate_file'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'signature_name',
        'signature_title'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'app_id',
        'media'
    ];

    /**
     * {@inheritdoc}
     */
    public $incrementing = false;

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'app_id';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

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
     * Get the certificate media file.
     *
     * @return \Plank\Mediable\Media|null
     */
    public function getCertificateFileAttribute()
    {
        return $this->firstMedia(self::MEDIA_CERTIFICATE);
    }

    /**
     * Get the signature media file.
     *
     * @return \Plank\Mediable\Media|null
     */
    public function getSignatureFileAttribute()
    {
        return $this->firstMedia(self::MEDIA_SIGNATURE);
    }

    /**
     * Get the signet media file.
     *
     * @return \Plank\Mediable\Media|null
     */
    public function getSignetFileAttribute()
    {
        return $this->firstMedia(self::MEDIA_SIGNET);
    }
}
