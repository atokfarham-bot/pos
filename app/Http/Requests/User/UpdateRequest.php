<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'jenis_id'       => 'required|exists:jenis,id',
            'name'           => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    /**
     * Custom message for validation errors.
     */
    public function messages(): array
    {
        return [
            'jenis_id.required'       => 'Jenis produk wajib dipilih.',
            'jenis_id.exists'         => 'Jenis produk yang dipilih tidak valid.',
            'name.required'           => 'Nama produk wajib diisi.',
            'name.max'                => 'Nama produk maksimal 255 karakter.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'purchase_price.numeric'  => 'Harga beli harus berupa angka.',
            'selling_price.required'  => 'Harga jual wajib diisi.',
            'selling_price.numeric'   => 'Harga jual harus berupa angka.',
            'stock.required'          => 'Stok wajib diisi.',
            'stock.integer'           => 'Stok harus berupa angka bulat.',
            'foto.image'              => 'File harus berupa gambar.',
            'foto.mimes'              => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'foto.max'                => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}