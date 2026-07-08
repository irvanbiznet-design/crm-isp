<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\CustomerService;
use App\Repositories\CustomerRepository;
use Exception;

class CustomerServiceTest extends TestCase
{
    protected $service;
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(CustomerRepository::class);
        $this->service = new CustomerService($this->repository);
    }

    public function test_get_all_customers()
    {
        $mockData = collect([
            ['id' => 1, 'name' => 'Customer 1'],
            ['id' => 2, 'name' => 'Customer 2'],
        ]);

        $this->repository->method('all')->willReturn($mockData);

        $result = $this->service->getAllCustomers();

        $this->assertNotEmpty($result);
        $this->assertEquals(2, $result->count());
    }

    public function test_create_customer_with_duplicate_number()
    {
        $this->expectException(Exception::class);

        $data = [
            'customer_number' => 'CUST001',
            'name' => 'Test Customer',
        ];

        $this->repository->method('findByCustomerNumber')->willReturn((object) $data);

        $this->service->createCustomer($data);
    }

    public function test_create_customer_success()
    {
        $data = [
            'customer_number' => 'CUST001',
            'name' => 'Test Customer',
        ];

        $this->repository->method('findByCustomerNumber')->willReturn(null);
        $this->repository->method('create')->willReturn((object) array_merge(['id' => 1], $data));

        $result = $this->service->createCustomer($data);

        $this->assertEquals('Test Customer', $result->name);
    }

    public function test_update_customer_success()
    {
        $data = ['name' => 'Updated Name'];
        $updated = (object) array_merge(['id' => 1, 'customer_number' => 'CUST001'], $data);

        $this->repository->method('find')->willReturn($updated);
        $this->repository->method('update')->willReturn($updated);

        $result = $this->service->updateCustomer(1, $data);

        $this->assertEquals('Updated Name', $result->name);
    }

    public function test_search_customers()
    {
        $mockResults = collect([
            ['id' => 1, 'name' => 'Budi Santoso'],
        ]);

        $this->repository->method('search')->willReturn($mockResults);

        $result = $this->service->searchCustomers('Budi');

        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result->count());
    }
}
