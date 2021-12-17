<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'value'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'id'
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}
