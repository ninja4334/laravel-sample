<?php

namespace App\Http\Requests\Users;

use App\Models\Supervisor;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserActivityHoursVerifyRequest extends FormRequest
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
            'activity_types'               => 'required|array',
            'activity_types.*.id'          => [
                'required',
                'integer',
                Rule::exists('user_activity_types', 'id')
                    ->where(function ($query) {
                        $supervisor = Supervisor::query()
                            ->where('email', $this->supervisor_email)
                            ->first();

                        $query->where('supervisor_id', $supervisor ? $supervisor->id : '');
                    })
                    ->whereNull('verified_at')
            ],
            'activity_types.*.is_verified' => 'required|boolean',
            'supervisor_email'             => 'required|email',
        ];
    }
}
