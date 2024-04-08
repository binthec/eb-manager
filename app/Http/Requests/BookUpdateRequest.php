<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            'filename' => 'nullable|string|max:255',
            'type' => 'nullable|numeric',
            'invoice' => 'nullable|boolean',
            'registration_number' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'file' => 'nullable',
            'publisher' => 'nullable|string|max:255',
            'issue_date' => 'nullable',
            'price' => 'nullable|numeric|max:255',
            'memo' => 'nullable|string|max:1500',
            'size' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'XResolution' => 'nullable|numeric',
            'YResolution' => 'nullable|numeric',
            'ResolutionUnit' => 'nullable|numeric',
            'lastModified' => 'nullable',
        ];
    }
}
