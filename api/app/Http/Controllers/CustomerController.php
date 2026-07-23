<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ElasticsearchService;

class CustomerController extends Controller
{
    
    protected ElasticsearchService $elasticsearch;


    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->filled('search')) {
            return $this->elasticsearch->searchCustomers($request->search);
        }

        return Customer::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated());

        $this->elasticsearch->indexCustomer($customer);

        return response()->json([
            'message' => 'Customer created successfully.',
            'data' => $customer,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, int $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        $customer->update($request->validated());

        $this->elasticsearch->indexCustomer($customer);

        return response()->json([
            'message' => 'Customer updated successfully',
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();
        $this->elasticsearch->deleteCustomer($customer);

        return response()->json([
            'message' => 'Customer deleted successfully',
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $customer = Customer::withTrashed()->findOrFail($id);

        $customer->restore();
        $this->elasticsearch->indexCustomer($customer);

        return response()->json([
            'message' => 'Customer restored successfully',
        ]);
    }
}
