<?php

namespace App\Models;

use App\Presenters\AppNotificationPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class AppNotification extends Model
{
    use SoftDeletes, PresentableTrait;

    /**
     * Types of sending interval.
     */
    const TYPE_ONCE = 'once';
    const TYPE_YEARLY = 'yearly';
    const TYPE_MONTHLY = 'monthly';
    const TYPE_DAILY = 'daily';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'type',
        'date',
        'title',
        'body'
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'date',
        'sent_at',
        'deleted_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'type_id',
        'sent_at'
    ];

    /**
     * @var string
     */
    protected $presenter = AppNotificationPresenter::class;

    /**
     * Retrieve the application type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AppType::class);
    }

    /**
     * Determine if attribute sent_at equal for current date.
     *
     * @return bool
     */
    public function isSentToday()
    {
        if ($this->getAttribute('sent_at')) {
            return $this->getAttribute('sent_at')->isToday();
        }

        return false;
    }

    /**
     * Types of notification.
     *
     * @return array
     */
    public static function types()
    {
        return [
            self::TYPE_ONCE,
            self::TYPE_YEARLY,
            self::TYPE_MONTHLY,
            self::TYPE_DAILY
        ];
    }

    /**
     * Get formatted date.
     *
     * @param mixed $value
     *
     * @return false|string
     */
    public function getDateAttribute($value)
    {
        return $this->present()->date($value);
    }
}
