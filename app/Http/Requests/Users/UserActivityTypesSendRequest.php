<?php

namespace App\Http\Requests\Users;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserActivityTypesSendRequest extends FormRequest
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
            'activity_types'      => 'required|array',
            'activity_types.*.id' => [
                'required',
                'integer',
                Rule::exists('user_activity_types', 'id')
                    ->where('user_id', Auth::id())
                    ->whereNull('verified_at')
            ],
            'supervisor_id'       => [
                'required',
                'integer',
                Rule::exists('supervisors', 'id')
                    ->where('member_id', Auth::id())
            ],
            'url'                 => 'required|url'
        ];
    }
}
