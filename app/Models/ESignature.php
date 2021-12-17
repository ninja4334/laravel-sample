<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ESignature extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name'
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'entity_id',
        'entity_type'
    ];

    /**
     * {@inheritdoc}
     */
    protected $table = 'electronic_signatures';

    /**
     * Format ip address.
     *
     * @param $value
     *
     * @return null|string
     */
    public function getIpAttribute($value)
    {
        return $value ? inet_ntop($value) : null;
    }

    /**
     * Format ip address.
     *
     * @param $value
     *
     * @return void
     */
    public function setIpAttribute($value)
    {
        $this->attributes['ip'] = inet_pton($value);
    }
}
