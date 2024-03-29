<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
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
            'filename' => 'required|string|max:255',
            'file' => 'required',
            'size' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'XResolution' => 'nullable|numeric',
            'YResolution' => 'nullable|numeric',
            'ResolutionUnit' => 'nullable|numeric',
            'lastModified' => 'required',
        ];
    }
}
