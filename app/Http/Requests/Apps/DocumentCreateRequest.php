<?php

namespace App\Http\Requests\Apps;

use App\Models\AppDocument;
use Illuminate\Foundation\Http\FormRequest;

class DocumentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $types = implode(',', AppDocument::types());

        return [
            'type'                 => 'required|in:' . $types,
            'metadata.title'       => 'required|string|max:255',
            'metadata.description' => 'string',
            'metadata.registrator' => 'string|max:100'
        ];
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('media_id', 'required|integer', function ($input) {
            return
                $input['type'] == AppDocument::TYPE_DOWNLOAD
                || $input['type'] == AppDocument::TYPE_SIGNATURE;
        });

        $validator->sometimes('media_id', 'media:application/pdf', function ($input) {
            return $input['type'] == AppDocument::TYPE_SIGNATURE;
        });

        $validator->sometimes('metadata.registrator', 'required', function ($input) {
            return $input['type'] == AppDocument::TYPE_SIGNATURE;
        });

        return $validator;
    }
}
