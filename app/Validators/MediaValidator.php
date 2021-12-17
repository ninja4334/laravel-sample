<?php

namespace App\Validators;

use App\Models\Media;

class MediaValidator
{
    /**
     * Check if an app has at least one reviewer.
     *
     * @param $attribute
     * @param $value
     * @param $params
     *
     * @return mixed
     */
    public function validateMedia($attribute, $value, $params)
    {
        $media = Media::find($value);

        return $media->mime_type == $params[0];
    }

    /**
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $params
     *
     * @return mixed
     */
    public function replacerMedia($message, $attribute, $rule, $params)
    {
        return str_replace(':values', implode(', ', $params), $message);
    }
}
