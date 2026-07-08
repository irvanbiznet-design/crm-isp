<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'priority' => 'required|in:low,medium,high,critical',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Pelanggan harus dipilih',
            'customer_id.exists' => 'Pelanggan tidak ditemukan',
            'title.required' => 'Judul tiket harus diisi',
            'description.required' => 'Deskripsi tiket harus diisi',
            'priority.required' => 'Prioritas harus dipilih',
        ];
    }
}
