<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Models\TicketHistory;
use Exception;

class TicketService
{
    protected $repository;

    public function __construct(TicketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTickets($perPage = 15)
    {
        return $this->repository->all($perPage);
    }

    public function getTicketById($id)
    {
        return $this->repository->find($id);
    }

    public function createTicket(array $data)
    {
        try {
            $data['ticket_number'] = $this->generateTicketNumber();
            $data['status'] = 'open';
            return $this->repository->create($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateTicket($id, array $data)
    {
        try {
            $ticket = $this->repository->find($id);
            
            if (isset($data['status']) && $data['status'] != $ticket->status) {
                $this->recordHistory($ticket, $data);
            }

            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteTicket($id)
    {
        return $this->repository->delete($id);
    }

    public function getTicketsByCustomer($customerId)
    {
        return $this->repository->getByCustomer($customerId);
    }

    public function getTicketsByStatus($status)
    {
        return $this->repository->getByStatus($status);
    }

    public function getTicketsByAssignee($userId)
    {
        return $this->repository->getByAssignee($userId);
    }

    public function getOpenTickets()
    {
        return $this->repository->getOpenTickets();
    }

    public function searchTickets($query)
    {
        return $this->repository->search($query);
    }

    private function generateTicketNumber()
    {
        $prefix = 'TKT';
        $date = now()->format('Ymd');
        $count = \DB::table('tickets')->whereDate('created_at', now())->count() + 1;
        return $prefix . $date . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    private function recordHistory($ticket, $data)
    {
        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'status_updated',
            'old_status' => $ticket->status,
            'new_status' => $data['status'] ?? $ticket->status,
        ]);
    }
}
