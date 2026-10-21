<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanKomentarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;   // akses sudah dijaga middleware auth dan policy
    }

    public function rules(): array
    {
        return [
            'isi' => ['required', 'string', 'min:3', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5']
        ];
    }

    public function messages(): array
    {
        return [
            'isi.required' => 'Komentar tidak boleh kosong.',
            'isi.min' => 'Komentar minimal :min karakter.',
            'isi.max' => 'Komentar maksimal :max karakter.',
        ];
    }
}
