<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppRenewalNotification extends Model
{
    use SoftDeletes;

    /**
     * Interval types.
     */
    const INTERVAL_TYPE_MONTH = 'month';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'interval' => 'object'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'interval',
        'message',
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'sent_at',
        'deleted_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'sent_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Retrieve the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class);
    }

    /**
     * Interval type list.
     *
     * @return array
     */
    public static function intervalTypes()
    {
        return [
            self::INTERVAL_TYPE_MONTH
        ];
    }
}
