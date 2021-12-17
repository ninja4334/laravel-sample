<?php

namespace App\Models;

use Storage;
use Plank\Mediable\Media as BaseMedia;
use Plank\Mediable\Mediable;

class Media extends BaseMedia
{
    use Mediable;

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'url'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'disk',
        'directory',
        'filename',
        'extension',
        'mime_type',
        'aggregate_type',
        'size',
        'created_at',
        'updated_at',
        'pivot'
    ];

    /**
     * Get the url of file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->getDiskPath());
    }
}
