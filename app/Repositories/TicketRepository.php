<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    protected $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function all($perPage = 15)
    {
        return $this->model->with(['customer', 'assignee'])->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->with(['customer', 'assignee', 'histories'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $ticket = $this->find($id);
        $ticket->update($data);
        return $ticket;
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

    public function getByAssignee($userId)
    {
        return $this->model->where('assigned_to', $userId)->paginate(15);
    }

    public function getOpenTickets()
    {
        return $this->model->whereIn('status', ['open', 'on_progress'])->paginate(15);
    }

    public function search($query)
    {
        return $this->model
            ->where('ticket_number', 'like', "%$query%")
            ->orWhere('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->paginate(15);
    }
}
