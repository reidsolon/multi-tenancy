<?php

namespace App\Http\Requests\Main\Tenant;

use App\Models\Domain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'domain' => ['required', 'string', 'max:16', function (string $attribute, mixed $value, \Closure $fail) {
                if (Domain::where('domain', 'like', "$value%")->exists())
                    $fail('Domain registered already.');
            }],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', Rule::requiredIf(!empty($this->email))]
        ];
    }
}
