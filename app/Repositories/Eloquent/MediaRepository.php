<?php

namespace App\Repositories\Eloquent;

use App\Models\Media;
use App\Repositories\Contracts\MediaRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class MediaRepository extends BaseRepository implements MediaRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Media::class;
    }
}
