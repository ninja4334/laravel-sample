<?php

namespace App\Http\Requests\Boards;

use App\Models\AppNotification;
use Illuminate\Foundation\Http\FormRequest;

class AppNotificationCreateRequest extends FormRequest
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
        $types = implode(AppNotification::types(), ',');

        return [
            'type'  => 'required|string|in:' . $types,
            'date'  => 'required|date_format:m/d/Y',
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ];
    }
}
