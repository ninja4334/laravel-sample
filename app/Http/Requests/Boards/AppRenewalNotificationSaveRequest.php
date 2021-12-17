<?php

namespace App\Http\Requests\Boards;

use App\Models\AppRenewalNotification;
use Illuminate\Foundation\Http\FormRequest;

class AppRenewalNotificationSaveRequest extends FormRequest
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
        $intervalTypes = implode(',', AppRenewalNotification::intervalTypes());

        return [
            'app_id'                         => 'required|exists:apps,id',
            'notifications'                  => 'array',
            'notifications.*.id'             => 'integer|exists:app_renewal_notifications,id',
            'notifications.*.interval'       => 'required|array',
            'notifications.*.interval.type'  => 'required|in:' . $intervalTypes,
            'notifications.*.interval.value' => 'required|integer',
            'notifications.*.message'        => 'required|string'
        ];
    }
}
