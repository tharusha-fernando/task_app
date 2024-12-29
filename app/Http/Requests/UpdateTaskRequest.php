<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => auth()->id(),
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' =>
            [
                'required',
                Rule::unique('tasks')->ignore($this->task),
                // 'unique:tasks,name',
            ],
            // 'required|unique:tasks,name',
            'project_id' => 'nullable|exists:projects,id',
            'created_by' => 'required|exists:users,id',
            //
        ];
    }
}
