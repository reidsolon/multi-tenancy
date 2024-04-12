<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:products,name'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'photos' => ['array'],
            'photos.*' => ['image']
        ];
    }
}
