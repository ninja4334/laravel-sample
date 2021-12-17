<?php

namespace App\Http\Requests\Boards;

use Illuminate\Foundation\Http\FormRequest;

class StripeBankAccountCreateRequest extends FormRequest
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
            'account_number'      => 'required|numeric',
            'routing_number'      => 'required|numeric',
            'account_holder_name' => 'required|string',
            'account_holder_type' => 'required|in:individual,company',
        ];
    }
}
