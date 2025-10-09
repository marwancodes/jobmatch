<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:job_vacancies,title',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'type' => 'required|string|max:255',

            // Job Category Details
            'categoryId' => 'required|string|max:255',

            // Company details
            'companyId' => 'required|string|max:255',

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'title.string' => 'The job title must be a string.',
            'title.max' => 'The job title may not be greater than 255 characters.',
            'title.unique' => 'The job title has already been taken.',
            'location.required' => 'The location is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than 255 characters.',
            'salary.required' => 'The salary is required.',
            'salary.string' => 'The salary must be a string.',
            'salary.max' => 'The salary may not be greater than 255 characters.',
            'type.string' => 'The type must be a string.',
            'type.required' => 'The type is required.',
            'type.max' => 'The type may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'description.required' => 'The description is required.',
            'description.max' => 'The description may not be greater than 255 characters.',

            // Job Category details
            'categoryId.required' => 'The job category is required.',
            'categoryId.string' => 'The job category must be a string.',
            'categoryId.max' => 'The job category may not be greater than 255 characters.',

            // Company details
            'companyId.required' => 'The company is required.',
            'companyId.string' => 'The company must be a string.',
            'companyId.max' => 'The company may not be greater than 255 characters.',
            
        ];
    }
}
