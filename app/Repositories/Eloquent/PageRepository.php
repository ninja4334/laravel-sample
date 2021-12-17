<?php

namespace App\Repositories\Eloquent;

use App\Models\Page;
use App\Repositories\Contracts\PageRepositoryContract;
use Freevital\Repository\Eloquent\BaseRepository;

class PageRepository extends BaseRepository implements PageRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Page::class;
    }
}
