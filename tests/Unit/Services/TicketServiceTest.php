<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\TicketService;
use App\Repositories\TicketRepository;

class TicketServiceTest extends TestCase
{
    protected $service;
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(TicketRepository::class);
        $this->service = new TicketService($this->repository);
    }

    public function test_get_all_tickets()
    {
        $mockData = collect([
            ['id' => 1, 'ticket_number' => 'TKT001', 'status' => 'open'],
            ['id' => 2, 'ticket_number' => 'TKT002', 'status' => 'closed'],
        ]);

        $this->repository->method('all')->willReturn($mockData);

        $result = $this->service->getAllTickets();

        $this->assertNotEmpty($result);
        $this->assertEquals(2, $result->count());
    }

    public function test_create_ticket_success()
    {
        $data = [
            'customer_id' => 1,
            'title' => 'Internet tidak stabil',
            'description' => 'Kecepatan internet sering turun',
            'priority' => 'high',
        ];

        $expected = (object) array_merge(
            $data,
            [
                'id' => 1,
                'ticket_number' => 'TKT20240701001',
                'status' => 'open',
            ]
        );

        $this->repository->method('create')->willReturn($expected);

        $result = $this->service->createTicket($data);

        $this->assertEquals('Internet tidak stabil', $result->title);
        $this->assertEquals('open', $result->status);
    }

    public function test_get_open_tickets()
    {
        $mockData = collect([
            ['id' => 1, 'status' => 'open'],
            ['id' => 2, 'status' => 'on_progress'],
        ]);

        $this->repository->method('getOpenTickets')->willReturn($mockData);

        $result = $this->service->getOpenTickets();

        $this->assertEquals(2, $result->count());
    }

    public function test_search_tickets()
    {
        $mockData = collect([
            ['id' => 1, 'title' => 'Internet tidak stabil'],
        ]);

        $this->repository->method('search')->willReturn($mockData);

        $result = $this->service->searchTickets('Internet');

        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result->count());
    }
}
