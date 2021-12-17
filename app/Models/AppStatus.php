<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppStatus extends Model
{
    /**
     * System names.
     */
    const SYSTEM_NAME_SUBMITTED = 'submitted';
    const SYSTEM_NAME_APPROVED = 'approved';
    const SYSTEM_NAME_DENIED = 'denied';
    const SYSTEM_NAME_DEFERRED = 'deferred';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_auto'    => 'boolean',
        'is_default' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'message',
        'is_auto'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'board_id',
        'is_default',
        'created_at',
        'updated_at'
    ];

    /**
     * Retrieve submissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'status_id');
    }
}
