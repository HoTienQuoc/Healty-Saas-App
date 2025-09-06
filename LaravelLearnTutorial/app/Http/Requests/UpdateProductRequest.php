<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|max:255|unique:products,name,'.$this->product->id,
            'description' => 'required|max:5000',
            'image_path' => 'image|mimes:png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'image_path.max' => 'The thumbnail must not be greater than 2MB.',
            'image_path.image' => 'The thumbnail must be an image.',
            'image_path.mimes' => 'The thumbnail must be of type png or jpg.',
        ];
    }
}
