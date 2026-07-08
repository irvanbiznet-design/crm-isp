<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Exception;

class CustomerService
{
    protected $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllCustomers($perPage = 15)
    {
        return $this->repository->all($perPage);
    }

    public function getCustomerById($id)
    {
        return $this->repository->find($id);
    }

    public function createCustomer(array $data)
    {
        try {
            if ($this->repository->findByCustomerNumber($data['customer_number'])) {
                throw new Exception('Nomor pelanggan sudah terdaftar');
            }

            return $this->repository->create($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateCustomer($id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteCustomer($id)
    {
        return $this->repository->delete($id);
    }

    public function getCustomersByStatus($status)
    {
        return $this->repository->getByStatus($status);
    }

    public function getCustomersByArea($areaId)
    {
        return $this->repository->getByArea($areaId);
    }

    public function searchCustomers($query)
    {
        return $this->repository->search($query);
    }

    public function getDueToday()
    {
        return $this->repository->getDueToday();
    }
}
