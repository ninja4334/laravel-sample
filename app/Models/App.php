<?php

namespace App\Models;

use App\Presenters\AppPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Plank\Mediable\Mediable;

class App extends Model
{
    use Mediable, PresentableTrait, SoftDeletes;

    /**
     * Media tags.
     */
    const MEDIA_MAIN = 'main';
    const MEDIA_REQUIRED = 'required';
    const MEDIA_APPROVED = 'approved';

    /**
     * {@inheritdoc}
     */
    protected $appends = [
        'file',
        'required_files',
        'sale_price_by_bank',
        'sale_price_by_card',
        'link'
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'fields'        => 'object',
        'price'         => 'float',
        'filling_stage' => 'integer',
        'settings'      => 'object',
        'is_active'     => 'boolean'
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = [
        'renewal_date',
        'deleted_at'
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'type_id',
        'profession_id',
        'title',
        'fields',
        'price',
        'renewal_years',
        'renewal_date',
        'approved_text'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'board_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'media'
    ];

    /**
     * @var string
     */
    protected $presenter = AppPresenter::class;

    /**
     * Retrieve application activity item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activity()
    {
        return $this->hasOne(AppActivity::class);
    }

    /**
     * Retrieve licensing board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Retrieve application certificate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function certificate()
    {
        return $this->hasOne(AppCertificate::class);
    }

    /**
     * Retrieve application checklist items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklist()
    {
        return $this->hasMany(AppChecklist::class);
    }

    /**
     * Retrieve application documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(AppDocument::class);
    }

    /**
     * Retrieve board profession.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profession()
    {
        return $this->belongsTo(BoardProfession::class);
    }

    /**
     * Retrieve application requirement items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requirements()
    {
        return $this->hasMany(AppRequirement::class);
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
     * Retrieve application users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'x_user_app');
    }

    /**
     * Retrieve application type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AppType::class);
    }

    /**
     * Filter query by board id.
     *
     * @param     $query
     * @param int $board_id
     *
     * @return mixed
     */
    public function scopeByBoardId(Builder $query, int $board_id)
    {
        return $query->whereHas('board', function (Builder $query) use ($board_id) {
            return $query->where('id', $board_id);
        });
    }

    /**
     * Get approved media files.
     *
     * @return \Plank\Mediable\MediableCollection
     */
    public function getApprovedFilesAttribute()
    {
        return $this->getMedia(self::MEDIA_APPROVED);
    }

    /**
     * Get main media file.
     *
     * @return \Plank\Mediable\Media|null
     */
    public function getFileAttribute()
    {
        return $this->firstMedia(self::MEDIA_MAIN);
    }

    /**
     * Get the required media files.
     *
     * @return \Plank\Mediable\MediableCollection
     */
    public function getRequiredFilesAttribute()
    {
        return $this->getMedia(self::MEDIA_REQUIRED);
    }

    /**
     * Get a link of application.
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        return $this->present()->link();
    }

    /**
     * Get formatted renewal date.
     *
     * @param mixed $value
     *
     * @return false|string
     */
    public function getRenewalDateAttribute($value)
    {
        return $this->present()->renewal_date($value);
    }

    /**
     * Get sum of application requirements hours.
     *
     * @return float|integer|null
     */
    public function getRequirementHoursAttribute()
    {
        if ($this->activity) {
            return $this->activity->getAttribute('education_hours');
        }

        return $this->requirements->sum('hours');
    }

    /**
     * Calculate the price for sale by bank transaction.
     *
     * @return float|int|mixed
     */
    public function getSalePriceByBankAttribute()
    {
        $board = $this->board;
        $price = $this->price;

        $stripeFee = config('services.stripe.bank_fee.percentages');

        if ($board->is_required_bank_fee) {
            $stripeFee += $board->is_required_bank_fee;
            $priceFee = ($price * $stripeFee) / 100;

            $price = $price + $priceFee;
        }

        return $price;
    }

    /**
     * Calculate the price for sale by card transaction.
     *
     * @return float|int|mixed
     */
    public function getSalePriceByCardAttribute()
    {
        $board = $this->board;
        $price = $this->price;

        $stripeFee = config('services.stripe.card_fee.percentages');

        if ($board->is_required_card_fee) {
            $stripeFee += $board->card_fee;
            $priceFee = ($price * $stripeFee) / 100 + config('services.stripe.card_fee.amount');

            $price = $price + $priceFee;
        }

        return $price;
    }
}
