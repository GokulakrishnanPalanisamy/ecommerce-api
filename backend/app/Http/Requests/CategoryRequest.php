<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('category.create')) {

            return [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
                'description' => ['nullable', 'string'],
            ];

        } elseif ($this->routeIs('category.update')) {

            $id = $this->route('id');

            return [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,'. $id],
                'description' => ['nullable', 'string'],
            ];

        } else {

            return [];

        }
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [

            // Name
            'name.required' => 'Category name is required.',
            'name.string' => 'Category name must be a string.',
            'name.max' => 'Category name cannot exceed 255 characters.',

            // Slug
            'slug.required' => 'Category slug is required.',
            'slug.string' => 'Category slug must be a string.',
            'slug.max' => 'Category slug cannot exceed 255 characters.',
            'slug.unique' => 'This category slug already exists.',

            // Description
            'description.string' => 'Description must be a string.',
        ];
    }
}
