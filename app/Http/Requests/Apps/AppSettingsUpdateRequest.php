<?php

namespace App\Http\Requests\Apps;

use Illuminate\Foundation\Http\FormRequest;

class AppSettingsUpdateRequest extends FormRequest
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
            'settings'                                                                 => 'required|array',
            'settings.tabs'                                                            => 'required|array',
            'settings.tabs.required_items.is_visible'                                  => 'required|boolean',
            'settings.tabs.checklist.is_visible'                                       => 'required|boolean',
            'settings.tabs.certificate.is_visible'                                     => 'required|boolean',
            'settings.tabs.certificate.sections'                                       => 'required|array',
            'settings.tabs.certificate.sections.approved_app_text.is_visible'          => 'required|boolean',
            'settings.tabs.certificate.sections.approved_app_documentation.is_visible' => 'required|boolean',
            'settings.tabs.ce_activities.is_visible'                                   => 'required|boolean'
        ];
    }
}
