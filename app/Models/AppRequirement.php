<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppRequirement extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'hours' => 'float'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title',
        'hours'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'app_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Retrieve application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }
}
