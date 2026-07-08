<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Exception;

class InvoiceController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $invoices = $this->service->getAllInvoices($perPage);
            
            return response()->json([
                'message' => 'Data invoice berhasil diambil',
                'data' => $invoices,
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
                'invoice_date' => 'required|date',
                'due_date' => 'required|date',
                'amount' => 'required|numeric|min:0',
                'tax' => 'nullable|numeric|min:0',
                'discount' => 'nullable|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'status' => 'required|in:unpaid,paid,overdue,partial',
            ]);

            $invoice = $this->service->createInvoice($validated);

            return response()->json([
                'message' => 'Invoice berhasil dibuat',
                'data' => $invoice,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        try {
            $invoice = $this->service->getInvoiceById($id);
            
            return response()->json([
                'message' => 'Data invoice berhasil diambil',
                'data' => $invoice,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'sometimes|in:unpaid,paid,overdue,partial',
                'amount' => 'sometimes|numeric|min:0',
                'total' => 'sometimes|numeric|min:0',
            ]);

            $invoice = $this->service->updateInvoice($id, $validated);

            return response()->json([
                'message' => 'Invoice berhasil diperbarui',
                'data' => $invoice,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->deleteInvoice($id);
            
            return response()->json([
                'message' => 'Invoice berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function unpaid()
    {
        try {
            $invoices = $this->service->getUnpaidInvoices();
            
            return response()->json([
                'message' => 'Data invoice belum dibayar berhasil diambil',
                'data' => $invoices,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
