<?php

namespace App\Http\Requests\Apps;

use Illuminate\Foundation\Http\FormRequest;

class AppUpdateRequest extends FormRequest
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
        return [
            'type_id'      => 'sometimes',
            'title'        => 'required|string|max:255',
            'price'        => 'numeric|nullable',
            'renewal_date' => 'date_format:m/d/Y|nullable'
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

        $validator->sometimes('type_id', 'integer|exists:app_types,id', function ($input) {
            return $input->type_id != 'none';
        });

        $validator->sometimes('renewal_years', 'required|integer', function ($input) {
            return $input->type_id != 'none';
        });

        $validator->sometimes('renewal_years', 'integer|nullable', function ($input) {
            return $input->type_id == 'none';
        });

        return $validator;
    }
}
