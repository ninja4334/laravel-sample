<?php

namespace App\Models;

use Freevital\Stripe\StripeManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'card_fee'                             => 'float',
        'bank_fee'                             => 'float',
        'additional_bank_fee'                  => 'float',
        'is_required_card_fee'                 => 'boolean',
        'is_required_bank_fee'                 => 'boolean',
        'is_supervisors_verification_required' => 'boolean',
        'is_active'                            => 'boolean'
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
        'state_id',
        'supervisors_app_id',
        'title',
        'abbreviation',
        'address',
        'email',
        'phone',
        'card_fee',
        'bank_fee',
        'additional_bank_fee',
        'is_required_card_fee',
        'is_required_bank_fee',
        'is_supervisors_verification_required'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'additional_bank_fee',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Retrieve applications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apps()
    {
        return $this->hasMany(App::class);
    }

    /**
     * Retrieve permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'board_id');
    }

    /**
     * Retrieve board professions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function professions()
    {
        return $this->hasMany(BoardProfession::class);
    }

    /**
     * Retrieve roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'x_board_role');
    }

    /**
     * Retrieve state.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Retrieve application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisors_app()
    {
        return $this->belongsTo(App::class);
    }

    /**
     * Retrieve application types.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function types()
    {
        return $this->hasMany(AppType::class);
    }

    /**
     * Retrieve users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'x_board_user');
    }

    /**
     * Get the bank accounts of board.
     *
     * @return bool
     */
    public function getIsChargeableAttribute()
    {
        $account = app(StripeManager::class)->account($this)->retrieve();

        if ($account) {
            return $account->retrieve()->isChargeable();
        }

        return false;
    }
}
