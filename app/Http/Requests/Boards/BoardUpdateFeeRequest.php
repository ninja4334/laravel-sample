<?php

namespace App\Http\Requests\Boards;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Route;

class BoardUpdateFeeRequest extends FormRequest
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
            'card_fee'             => 'numeric',
            'bank_fee'             => 'numeric',
            'additional_bank_fee'  => 'numeric',
            'is_required_card_fee' => 'boolean',
            'is_required_bank_fee' => 'boolean'
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

        $validator->sometimes('additional_bank_fee', 'required', function () {
            return Auth::user()->can('boards.fee.manage');
        });

        return $validator;
    }
}
