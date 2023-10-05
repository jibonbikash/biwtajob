<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'vacancies' => 'required',
            'job_id' => 'required',
            'age_calculation' => 'required',
            'apply_fee' => 'required',
            'application_deadline' => 'required',
            'jobcurbday' => 'required',
             'min_age' => 'required',
             'max_age' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Job Title is required',
            'description.required' => 'Job Description is required',
        ];
    }
}
