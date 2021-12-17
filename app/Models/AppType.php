<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AppType extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'acronym'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'board_id'
    ];

    /**
     * {@inheritdoc}
     */
    public $timestamps = false;

    /**
     * Retrieve applications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apps()
    {
        return $this->hasMany(App::class, 'id');
    }

    /**
     * Retrieve application notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    /**
     * Retrieve submissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'type_id');
    }

    /**
     * Filter query by board id.
     *
     * @param Builder $query
     * @param int     $board_id
     *
     * @return mixed
     */
    public function scopeByBoardId(Builder $query, int $board_id)
    {
        return $query->whereHas('boards', function (Builder $query) use ($board_id) {
            return $query->where('id', $board_id);
        });
    }
}
