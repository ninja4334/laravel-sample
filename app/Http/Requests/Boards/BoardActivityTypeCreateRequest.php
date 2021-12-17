<?php

namespace App\Http\Requests\Boards;

use App\Models\BoardActivityType;
use Illuminate\Foundation\Http\FormRequest;
use Route;

class BoardActivityTypeCreateRequest extends FormRequest
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
        $notificationTypes = implode(',', BoardActivityType::notificationTypes());

        return [
            'name'                     => 'required|string|max:255',
            'notification_type'        => 'required_with:notification_date|in:' . $notificationTypes,
            'notification_date'        => 'required_with:notification_type|date_format:Y-m-d',
            'is_required_verification' => 'required|boolean'
        ];
    }
}
