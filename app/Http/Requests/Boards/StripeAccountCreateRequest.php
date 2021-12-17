<?php

namespace App\Http\Requests\Boards;

use Illuminate\Foundation\Http\FormRequest;

class StripeAccountCreateRequest extends FormRequest
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
            'legal_entity.type'                    => 'required|in:individual,company',
            'legal_entity.first_name'              => 'required|string|max:36',
            'legal_entity.last_name'               => 'required|string|max:36',
            'legal_entity.business_name'           => 'required_if:legal_entity.type,company|string',
            'legal_entity.business_tax_id'         => 'required_if:legal_entity.type,company|numeric',
            'legal_entity.dob.day'                 => 'required|numeric|between:1,31',
            'legal_entity.dob.month'               => 'required|numeric|between:1,12',
            'legal_entity.dob.year'                => 'required|numeric|between:1900,2100',
            'legal_entity.address.city'            => 'required|string',
            'legal_entity.address.line1'           => 'required|string',
            'legal_entity.address.postal_code'     => 'required|numeric',
            'legal_entity.address.state'           => 'required|string',
            'legal_entity.personal_id_number'      => 'required|numeric',
            'legal_entity.verification_document'   => 'required',
            'external_account.object'              => 'required|in:bank_account',
            'external_account.account_holder_type' => 'required|in:individual,company',
            'external_account.account_number'      => 'required|numeric',
            'external_account.routing_number'      => 'required|numeric',
            'external_account.account_holder_name' => 'required|string',
        ];
    }
}
