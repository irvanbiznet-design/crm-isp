<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:15',
            'email' => 'sometimes|email|max:255',
            'address' => 'sometimes|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'sometimes|in:active,suspend,inactive',
            'due_date' => 'sometimes|date',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Nama harus berupa string',
            'phone.string' => 'Nomor telepon harus berupa string',
            'email.email' => 'Email harus valid',
        ];
    }
}
