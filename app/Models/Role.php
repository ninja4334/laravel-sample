<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_system' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'display_name',
        'description'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'is_system',
        'created_at',
        'updated_at'
    ];

    /**
     * Retrieve boards.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boards()
    {
        return $this->belongsToMany(Board::class, 'x_board_role');
    }

    /**
     * Retrieve permissions.
     *
     * @return $this
     */
    public function perms()
    {
        return parent::perms()->withPivot('board_id');
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
        return $query->whereHas('boards', function ($query) use ($board_id) {
            return $query->where('board_id', $board_id);
        });
    }

    /**
     * Exclude system roles from query.
     *
     * @param $query
     */
    public function scopeWithoutSystem($query)
    {
        return $query->whereNotIn('name', ['super_admin', 'admin', 'member']);
    }

    /**
     * Exclude Super Admin role from query.
     *
     * @param $query
     */
    public function scopeWithoutSuperAdmin($query)
    {
        return $query->where('name', '<>', 'super_admin');
    }

    /**
     * Exclude Member role from query.
     *
     * @param $query
     */
    public function scopeWithoutMember($query)
    {
        return $query->where('name', '<>', 'member');
    }

    /**
     * Exclude System role from query.
     *
     * @param $query
     */
    public function scopeWithoutSystemRole($query)
    {
        return $query->where('name', '<>', 'system');
    }
}
