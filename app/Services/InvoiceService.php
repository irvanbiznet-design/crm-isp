<?php

namespace App\Services;

use App\Repositories\InvoiceRepository;
use App\Repositories\CustomerRepository;
use Exception;

class InvoiceService
{
    protected $repository;
    protected $customerRepository;

    public function __construct(InvoiceRepository $repository, CustomerRepository $customerRepository)
    {
        $this->repository = $repository;
        $this->customerRepository = $customerRepository;
    }

    public function getAllInvoices($perPage = 15)
    {
        return $this->repository->all($perPage);
    }

    public function getInvoiceById($id)
    {
        return $this->repository->find($id);
    }

    public function createInvoice(array $data)
    {
        try {
            $customer = $this->customerRepository->find($data['customer_id']);
            if (!$customer) {
                throw new Exception('Pelanggan tidak ditemukan');
            }

            $data['invoice_number'] = $this->generateInvoiceNumber();
            return $this->repository->create($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateInvoice($id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteInvoice($id)
    {
        return $this->repository->delete($id);
    }

    public function getInvoicesByCustomer($customerId)
    {
        return $this->repository->getByCustomer($customerId);
    }

    public function getInvoicesByStatus($status)
    {
        return $this->repository->getByStatus($status);
    }

    public function getUnpaidInvoices()
    {
        return $this->repository->getUnpaid();
    }

    public function getTotalRevenue($startDate = null, $endDate = null)
    {
        return $this->repository->getTotalRevenue($startDate, $endDate);
    }

    private function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $count = \DB::table('invoices')->whereDate('created_at', now())->count() + 1;
        return $prefix . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
