<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display list of customers
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(10);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store new customer
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('customers', 'public');
        }

        // Card security (store last 4 digits only)
        if ($request->card_number) {
            $data['card_last_four'] = substr($request->card_number, -4);
        }

        Customer::create($data);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer added successfully');
    }

    /**
     * Show single customer
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show edit form
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update customer
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();


        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('customers', 'public');
        }

        if ($request->card_number) {
            $data['card_last_four'] = substr(
                preg_replace('/\s+/', '', $request->card_number),
                -4
            );
        }

        

        $customer->update($data);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully');
    }

    /**
     * Delete customer
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully');
    }
}
