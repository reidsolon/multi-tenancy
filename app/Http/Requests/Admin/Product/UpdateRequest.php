<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->route('product')) {
            $productId = $this->route('product')->id;
        } else {
            $productId = $this->route('id');
        }

        return [
            'name' => ['nullable', 'string', "unique:products,name,$productId"],
            'description' => ['nullable', 'string'],
            'photos' => ['array'],
            'photos.*' => ['image'],
            'delete_photos' => ['sometimes', 'array'],
            'delete_photos.*' => ['exists:products,id']
        ];
    }
}
