<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'abbreviation',
        'name'
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;
}
