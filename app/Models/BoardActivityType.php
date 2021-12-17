<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardActivityType extends Model
{
    /**
     * Notification types.
     */
    const NOTIFICATION_TYPE_ONCE = 'once';
    const NOTIFICATION_TYPE_WEEKLY = 'weekly';
    const NOTIFICATION_TYPE_MONTHLY = 'monthly';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_required_verification' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'notification_date'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'notification_type',
        'notification_date',
        'is_required_verification'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'board_id'
    ];

    /**
     * Retrieve board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * List of notification types.
     *
     * @return array
     */
    public static function notificationTypes()
    {
        return [
            self::NOTIFICATION_TYPE_ONCE,
            self::NOTIFICATION_TYPE_WEEKLY,
            self::NOTIFICATION_TYPE_MONTHLY
        ];
    }
}
