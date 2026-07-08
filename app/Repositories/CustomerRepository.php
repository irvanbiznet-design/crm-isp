<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function all($perPage = 15)
    {
        return $this->model->with(['package', 'area', 'router', 'olt', 'onu'])->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->with(['package', 'area', 'router', 'olt', 'onu'])->findOrFail($id);
    }

    public function findByCustomerNumber($customerNumber)
    {
        return $this->model->where('customer_number', $customerNumber)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $customer = $this->find($id);
        $customer->update($data);
        return $customer;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getByStatus($status)
    {
        return $this->model->where('status', $status)->paginate(15);
    }

    public function getByArea($areaId)
    {
        return $this->model->where('area_id', $areaId)->paginate(15);
    }

    public function search($query)
    {
        return $this->model
            ->where('customer_number', 'like', "%$query%")
            ->orWhere('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone', 'like', "%$query%")
            ->paginate(15);
    }

    public function getDueToday()
    {
        return $this->model->where('due_date', now()->toDateString())->get();
    }
}
