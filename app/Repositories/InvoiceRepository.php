<?php

namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository
{
    protected $model;

    public function __construct(Invoice $model)
    {
        $this->model = $model;
    }

    public function all($perPage = 15)
    {
        return $this->model->with('customer')->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->with('customer')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $invoice = $this->find($id);
        $invoice->update($data);
        return $invoice;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getByCustomer($customerId)
    {
        return $this->model->where('customer_id', $customerId)->paginate(15);
    }

    public function getByStatus($status)
    {
        return $this->model->where('status', $status)->paginate(15);
    }

    public function getUnpaid()
    {
        return $this->model->whereIn('status', ['unpaid', 'overdue'])->paginate(15);
    }

    public function getTotalRevenue($startDate = null, $endDate = null)
    {
        $query = $this->model->where('status', 'paid');
        
        if ($startDate) {
            $query->where('invoice_date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('invoice_date', '<=', $endDate);
        }
        
        return $query->sum('total');
    }
}
