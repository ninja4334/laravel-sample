<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'amount'   => 'float',
        'metadata' => 'object'
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'created_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'board_id',
        'user_id',
        'entity_id',
        'entity_type'
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * Retrieve user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retrieve submission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function submission()
    {
        return $this->morphTo('submission', 'entity_type', 'entity_id');
    }
}
