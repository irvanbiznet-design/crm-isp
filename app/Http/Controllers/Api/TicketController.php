<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Exception;

class TicketController extends Controller
{
    protected $service;

    public function __construct(TicketService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $tickets = $this->service->getAllTickets($perPage);
            
            return response()->json([
                'message' => 'Data tiket berhasil diambil',
                'data' => $tickets,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'title' => 'required|string',
                'description' => 'required|string',
                'photo' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'priority' => 'required|in:low,medium,high,critical',
            ]);

            $ticket = $this->service->createTicket($validated);

            return response()->json([
                'message' => 'Tiket berhasil dibuat',
                'data' => $ticket,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        try {
            $ticket = $this->service->getTicketById($id);
            
            return response()->json([
                'message' => 'Data tiket berhasil diambil',
                'data' => $ticket,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'sometimes|string',
                'description' => 'sometimes|string',
                'status' => 'sometimes|in:open,pending,on_progress,solved,closed',
                'priority' => 'sometimes|in:low,medium,high,critical',
                'assigned_to' => 'sometimes|exists:users,id',
            ]);

            $ticket = $this->service->updateTicket($id, $validated);

            return response()->json([
                'message' => 'Tiket berhasil diperbarui',
                'data' => $ticket,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->deleteTicket($id);
            
            return response()->json([
                'message' => 'Tiket berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function open()
    {
        try {
            $tickets = $this->service->getOpenTickets();
            
            return response()->json([
                'message' => 'Data tiket terbuka berhasil diambil',
                'data' => $tickets,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            $tickets = $this->service->searchTickets($query);
            
            return response()->json([
                'message' => 'Data tiket berhasil ditemukan',
                'data' => $tickets,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
