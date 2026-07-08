<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_number' => 'required|unique:customers|string',
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'area_id' => 'nullable|exists:areas,id',
            'package_id' => 'nullable|exists:internet_packages,id',
            'status' => 'required|in:active,suspend,inactive',
            'subscription_date' => 'required|date',
            'due_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'customer_number.required' => 'Nomor pelanggan harus diisi',
            'customer_number.unique' => 'Nomor pelanggan sudah terdaftar',
            'name.required' => 'Nama pelanggan harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
            'subscription_date.required' => 'Tanggal berlangganan harus diisi',
            'due_date.required' => 'Tanggal jatuh tempo harus diisi',
        ];
    }
}
