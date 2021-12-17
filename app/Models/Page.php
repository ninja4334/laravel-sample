<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_system' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'is_active'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'is_system',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
