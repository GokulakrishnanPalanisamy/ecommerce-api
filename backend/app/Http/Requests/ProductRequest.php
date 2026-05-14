<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if ($this->routeIs('product.create')) {

            return [
                'name' => ['required', 'string', 'max:255'],

                'category_ids' => ['nullable', 'array'],
                'category_ids.*' => ['integer','exists:categories,id'],

                'slug' => ['required', 'string', 'unique:products,slug'],
                'price' => ['required', 'numeric', 'min:0'],
                'stock' => ['required', 'integer', 'min:0'],
                'description' => ['nullable', 'string'],
            ];

        } elseif ($this->routeIs('product.update')) {

            $id = $this->route('id');
            return [
                'name' => ['required', 'string', 'max:255'],

                'category_ids' => ['nullable', 'array'],
                'category_ids.*' => ['integer','exists:categories,id'],

                'slug' => ['required', 'string', 'unique:products,slug,' . $id],
                'price' => ['required', 'numeric', 'min:0'],
                'stock' => ['required', 'integer', 'min:0'],
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
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be a valid string.',
            'name.max' => 'Product name cannot exceed 255 characters.',

            // Category IDs
            'category_ids.array' => 'Categories must be an array.',
            'category_ids.*.exists' => 'One or more selected categories are invalid.',

            // Slug
            'slug.required' => 'Product slug is required.',
            'slug.string' => 'Product slug must be a valid string.',
            'slug.unique' => 'This product slug already exists.',

            // Price
            'price.required' => 'Product price is required.',
            'price.numeric' => 'Product price must be a valid number.',
            'price.min' => 'Product price cannot be negative.',

            // Stock
            'stock.required' => 'Product stock is required.',
            'stock.integer' => 'Product stock must be an integer.',
            'stock.min' => 'Product stock cannot be negative.',

            // Description
            'description.string' => 'Product description must be a string.',
        ];
    }

    /**
     * Custom attribute names
     */
    public function attributes(): array
    {
        return [
            'name' => 'product name',
            'slug' => 'product slug',
            'price' => 'product price',
            'stock' => 'product stock',
            'description' => 'product description',
            'category_ids' => 'categories',
        ];
    }
}
