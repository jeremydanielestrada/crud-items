<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemsRequest extends FormRequest
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
            'item_name'      => 'string|max:255',
            'image_path'     => 'required|image|mimes:jpg,gif,png|max:5120',
            'price'          =>'required|numeric',
            'description'    => 'string|nullable|max:255',
        ];
    }
}
