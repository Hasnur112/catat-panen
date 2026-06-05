<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePanenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'jenis_padi'  => ['required', 'string', 'max:100'],
            'volume'      => ['required', 'numeric', 'min:0.01', 'max:99999'],
            'tanggal'     => ['required', 'date', 'before_or_equal:today'],
            'keterangan'  => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_padi.required'  => 'Jenis padi wajib dipilih.',
            'volume.required'      => 'Volume panen wajib diisi.',
            'volume.numeric'       => 'Volume harus berupa angka.',
            'volume.min'           => 'Volume minimal 0.01 kg.',
            'tanggal.required'     => 'Tanggal panen wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal panen tidak boleh melebihi hari ini.',
        ];
    }
}
