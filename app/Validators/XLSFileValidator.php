<?php

namespace App\Validators;

use App\Models\User;

class XLSFileValidator
{
    /**
     * Available extensions.
     *
     * @var array
     */
    private $extensions = [
        'xls',
        'xlsx',
        'csv'
    ];

    /**
     * Validate file extension of spreadsheets.
     *
     * @param $attribute
     * @param $value
     * @param $params
     *
     * @return mixed
     */
    public function validate($attribute, $value, $params)
    {
        $fileExtension = $value->getClientOriginalExtension();

        return in_array($fileExtension, $this->extensions);
    }

    /**
     *
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $params
     *
     * @return mixed
     */
    public function replacer($message, $attribute, $rule, $params)
    {
        return str_replace(':values', implode(', ', $this->extensions), $message);
    }
}
