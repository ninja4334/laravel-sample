<?php

namespace App\Http\Requests\Submissions;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionPayRequest extends FormRequest
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
            'stripe_id' => 'required_without:entity|string',
            'object'    => 'required|in:bank_account,card',

            'entity.number'    => 'required_without_all:stripe_id,entity.account_number|numeric',
            'entity.exp_month' => 'required_without_all:stripe_id,entity.account_number|numeric',
            'entity.exp_year'  => 'required_without_all:stripe_id,entity.account_number|numeric',
            'entity.cvc'       => 'required_without_all:stripe_id,entity.account_number',

            'entity.account_number'      => 'required_without_all:stripe_id,entity.number',
            'entity.account_holder_name' => 'required_without_all:stripe_id,entity.number',
            'entity.account_holder_type' => 'required_without_all:stripe_id,entity.number',
            'entity.routing_number'      => 'required_without_all:stripe_id,entity.number',
        ];
    }
}
