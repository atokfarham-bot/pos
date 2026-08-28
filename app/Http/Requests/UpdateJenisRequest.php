<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisRequest extends FormRequest
{
    /**
     * Menentukan apakah user berhak melakukan request ini.
     */
    public function authorize(): bool
    {
        return true; // sudah dicek via $this->authorize('update', $jenis) di controller
    }

    /**
     * Aturan validasi untuk request ini.
     */
    public function rules(): array
    {
        return [
            'nama_jenis' => 'required|string|max:255',
        ];
    }
}