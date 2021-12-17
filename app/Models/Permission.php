<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_system' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'display_name',
        'description'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'is_system',
        'created_at',
        'updated_at'
    ];
}
