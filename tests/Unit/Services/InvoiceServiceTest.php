<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\InvoiceService;
use App\Repositories\InvoiceRepository;
use App\Repositories\CustomerRepository;
use Exception;

class InvoiceServiceTest extends TestCase
{
    protected $service;
    protected $repository;
    protected $customerRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(InvoiceRepository::class);
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->service = new InvoiceService($this->repository, $this->customerRepository);
    }

    public function test_get_all_invoices()
    {
        $mockData = collect([
            ['id' => 1, 'invoice_number' => 'INV001', 'total' => 150000],
            ['id' => 2, 'invoice_number' => 'INV002', 'total' => 250000],
        ]);

        $this->repository->method('all')->willReturn($mockData);

        $result = $this->service->getAllInvoices();

        $this->assertNotEmpty($result);
        $this->assertEquals(2, $result->count());
    }

    public function test_create_invoice_with_invalid_customer()
    {
        $this->expectException(Exception::class);

        $data = [
            'customer_id' => 999,
            'total' => 150000,
        ];

        $this->customerRepository->method('find')->willThrowException(new Exception('Pelanggan tidak ditemukan'));

        $this->service->createInvoice($data);
    }

    public function test_get_unpaid_invoices()
    {
        $mockData = collect([
            ['id' => 1, 'status' => 'unpaid'],
            ['id' => 2, 'status' => 'overdue'],
        ]);

        $this->repository->method('getUnpaid')->willReturn($mockData);

        $result = $this->service->getUnpaidInvoices();

        $this->assertEquals(2, $result->count());
    }

    public function test_get_total_revenue()
    {
        $this->repository->method('getTotalRevenue')->willReturn(500000);

        $result = $this->service->getTotalRevenue('2024-01-01', '2024-01-31');

        $this->assertEquals(500000, $result);
    }
}
