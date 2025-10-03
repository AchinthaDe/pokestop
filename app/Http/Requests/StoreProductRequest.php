<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pokemon_name' => 'required|string|max:255',
            'card_name' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|url', // or image|mimes:jpg,png|max:2048 if upload
        ];
    }
}
