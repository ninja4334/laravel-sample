<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardProfession extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'board_id',
        'created_at',
        'updated_at'
    ];
}
