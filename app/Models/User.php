<?php

namespace App\Models;

use App\Observers\UserObserver;
use App\Presenters\UserPresenter;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait {
        EntrustUserTrait::restore insteadof SoftDeletes;
    }
    use Messagable, Notifiable, PresentableTrait, SoftDeletes;

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'full_name'
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
        'remember_token',
        'confirmation_token',
        'updated_at',
        'deleted_at',
        'roles'
    ];

    /**
     * @var string
     */
    protected $presenter = UserPresenter::class;

    /**
     * {@inheritdoc}
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($user) {
            if (!method_exists(\Config::get('auth.model'), 'bootSoftDeletes')) {
                $user->roles()->sync([]);
            }

            $user->email .= '_' . $user->id;
            $user->push();

            return true;
        });
    }

    /**
     * Retrieve applications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apps()
    {
        return $this->belongsToMany(App::class, 'x_user_app');
    }

    /**
     * Retrieve boards.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boards()
    {
        return $this->belongsToMany(Board::class, 'x_board_user');
    }

    /**
     * Retrieve submissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Retrieve supervisors.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supervisors()
    {
        return $this->hasMany(Supervisor::class, 'member_id');
    }

    /**
     * Filter query by application id.
     *
     * @param Builder $query
     * @param int     $app_id
     *
     * @return mixed
     */
    public function scopeByAppId(Builder $query, int $app_id)
    {
        return $query->whereHas('apps', function (Builder $query) use ($app_id) {
            return $query->where('id', $app_id);
        });
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

    /**
     * Filter query by role name.
     *
     * @param        $query
     * @param string $roleName
     *
     * @return mixed
     */
    public function scopeByRoleName(Builder $query, string $roleName)
    {
        return $query->whereHas('roles', function (Builder $query) use ($roleName) {
            return $query->where('name', $roleName);
        });
    }

    /**
     * Exclude a given role name from query.
     *
     * @param        $query
     * @param string $roleName
     *
     * @return mixed
     */
    public function scopeWithoutRoleName(Builder $query, string $roleName)
    {
        return $query->whereHas('roles', function (Builder $query) use ($roleName) {
            return $query->where('name', '<>', $roleName);
        });
    }

    /**
     * Get a full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->present()->full_name();
    }

    /**
     * Get the user's permissions.
     *
     * @return bool
     */
    public function getPermsAttribute()
    {
        if ($this->role) {
            return $this->role->perms;
        }
    }

    /**
     * Get the user's role.
     *
     * @return bool
     */
    public function getRoleAttribute()
    {
        return $this->roles->first();
    }

    /**
     * Set the password encryption.
     *
     * @param string $value
     *
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
