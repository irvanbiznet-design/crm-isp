<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'amount' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,overdue,partial',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Pelanggan harus dipilih',
            'customer_id.exists' => 'Pelanggan tidak ditemukan',
            'invoice_date.required' => 'Tanggal invoice harus diisi',
            'due_date.required' => 'Tanggal jatuh tempo harus diisi',
            'due_date.after' => 'Tanggal jatuh tempo harus setelah tanggal invoice',
            'amount.required' => 'Jumlah harus diisi',
            'total.required' => 'Total harus diisi',
        ];
    }
}
