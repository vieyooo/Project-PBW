<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi ditangani middleware auth
    }

    public function rules(): array
    {
        return [
            'nama_supplier' => 'required|string|max:100',
            'alamat'        => 'required|string',
            'no_telp'       => 'required|string|max:20',
            'fax'           => 'nullable|string|max:20',
            'pic_supplier'  => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'no_telp.required'       => 'Nomor telepon wajib diisi.',
            'pic_supplier.required'  => 'Nama penanggung jawab (PIC) wajib diisi.',
        ];
    }
}
