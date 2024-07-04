<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjetFormRequest extends FormRequest
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
            'nom' => ['required','max:255'],
            'description' => ['nullable','string'],
            'datedeb' => ['nullable','string'],
            'datefin' => ['nullable','string'],
            'budget' => ['required','string','max:255'],
            'image' => ['image','max:2048'],
        ];
    }
}
