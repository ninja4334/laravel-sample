<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Thread as BaseThread;

class Thread extends BaseThread
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'submission_id',
        'subject'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'submission_id',
        'deleted_at',
        'messages',
        'participants'
    ];

    /**
     * Retrieve submission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
