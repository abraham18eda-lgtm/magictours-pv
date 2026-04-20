<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
          return true; // Cambiar si quieres control de permisos
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
        'image' => 'nullable|image|max:2048',
            'site_id' => 'required|exists:sites,id',
            'price' => 'nullable|numeric',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'translations' => 'required|array',
            'translations.*.slug' => 'required|string|unique:tour_translations,slug',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.regular_price' => 'required|numeric',
            'translations.*.descount_price' => 'nullable|numeric',
            'translations.*.description' => 'nullable|string',
            'translations.*.description_2' => 'nullable|string',
            'translations.*.recommendations' => 'nullable|string',
            'translations.*.requirements' => 'nullable|string',
            'translations.*.faq' => 'nullable|string',
            'translations.*.info' => 'nullable|string',
            'translations.*.amenities' => 'nullable|array',
            'translations.*.amenities.*' => 'string', // Puede ser ID o nombre
            
        ];
    }
}
