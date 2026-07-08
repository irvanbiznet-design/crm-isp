<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Exception;

class CustomerController extends Controller
{
    protected $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $customers = $this->service->getAllCustomers($perPage);
            
            return response()->json([
                'message' => 'Data pelanggan berhasil diambil',
                'data' => $customers,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_number' => 'required|unique:customers',
                'name' => 'required|string',
                'nik' => 'nullable|string',
                'phone' => 'required|string',
                'email' => 'nullable|email',
                'photo' => 'nullable|string',
                'address' => 'required|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'area_id' => 'nullable|exists:areas,id',
                'package_id' => 'nullable|exists:internet_packages,id',
                'status' => 'required|in:active,suspend,inactive',
                'subscription_date' => 'required|date',
                'due_date' => 'required|date',
            ]);

            $validated['created_by'] = auth()->id();
            $customer = $this->service->createCustomer($validated);

            return response()->json([
                'message' => 'Pelanggan berhasil ditambahkan',
                'data' => $customer,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        try {
            $customer = $this->service->getCustomerById($id);
            
            return response()->json([
                'message' => 'Data pelanggan berhasil diambil',
                'data' => $customer,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string',
                'phone' => 'sometimes|string',
                'email' => 'sometimes|email',
                'address' => 'sometimes|string',
                'status' => 'sometimes|in:active,suspend,inactive',
            ]);

            $customer = $this->service->updateCustomer($id, $validated);

            return response()->json([
                'message' => 'Pelanggan berhasil diperbarui',
                'data' => $customer,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->deleteCustomer($id);
            
            return response()->json([
                'message' => 'Pelanggan berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            $customers = $this->service->searchCustomers($query);
            
            return response()->json([
                'message' => 'Data pelanggan berhasil ditemukan',
                'data' => $customers,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
