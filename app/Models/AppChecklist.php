<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppChecklist extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'body'
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
    protected $table = 'app_checklist';

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

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
