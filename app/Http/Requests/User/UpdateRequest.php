<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil ID dari objek user yang dikirim melalui route
        $user = $this->route('user');
        $userId = is_object($user) ? $user->id : $user;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            // Hapus 'confirmed' agar tidak error saat tidak ada input konfirmasi password
            'password' => 'nullable|string|min:8', 
            
            // Disesuaikan menjadi 'role_id' dan mengecek ke tabel roles
            'role_id' => 'required|exists:roles,id', 
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama user wajib diisi.',
            'name.max'          => 'Nama user maksimal 255 karakter.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan oleh user lain.',
            'password.min'      => 'Password minimal harus 8 karakter.',
            'role_id.required'  => 'Role wajib dipilih.',
            'role_id.exists'    => 'Role yang dipilih tidak valid.',
        ];
    }
}