<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppActivity extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'education_hours'   => 'float',
        'is_files_required' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'education_hours',
        'is_files_required'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'app_id'
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
}
