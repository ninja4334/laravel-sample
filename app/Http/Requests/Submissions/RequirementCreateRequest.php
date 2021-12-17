<?php

namespace App\Http\Requests\Submissions;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;

class RequirementCreateRequest extends FormRequest
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
            'requirement_id' => 'int|exists:app_requirements,id',
            'title'          => 'required|string',
            'format'         => 'required|string',
            'hours'          => 'required|numeric|max:1000',
            'passed_at'      => 'required|date_format:m/d/Y'
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

        $validator->sometimes('file', 'required', function ($input) {
            $submission = Submission::find($this->route('submission_id'));

            if ($submission->app && $submission->app->activity) {
                return $submission->app->activity->is_files_required;
            }
        });

        return $validator;
    }
}
