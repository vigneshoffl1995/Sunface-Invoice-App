<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'address' => 'required',
        //     'phone' => 'required',
        //     'email' => 'required|email',
        // ]);

        $request->validate([
    'name' => 'required|string|max:100',
    'company_name' => 'nullable|string|max:150',
    'customer_type' => 'required|in:b2b,b2c',
    'address' => 'required|string|max:255',
    // 'gst_number' => [
    //     'nullable',
    //     'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'
    // ],
    'gst_number' => [
        'nullable',
        'regex:/^(-|NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/',
        Rule::unique('customers', 'gst_number')->ignore($request->id)->where(function ($query) {
            return $query->where('gst_number', '!=', 'NA', '-');
        }),
    ],
    'phone' => [
        'required',
        'regex:/^([6-9]\d{9}|0\d{10})$/'
        //'regex:/^[6-9]\d{9}$/',

        //'unique:customers,phone'
    ],
    'email' => 'required|email'
]);
        

        Customer::create($request->all());
        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'address' => 'required',
        //     'phone' => 'required',
        //     'email' => 'required|email',
        // ]);

        $request->validate([
    'name' => 'required|string|max:100',
    'company_name' => 'nullable|string|max:150',
    'customer_type' => 'required|in:b2b,b2c',
    'address' => 'required|string|max:255',
    // 'gst_number' => [
    //     'nullable',
    //     'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'
    // ],
    'gst_number' => [
            'nullable',
            'regex:/^(-|NA|[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/',
            Rule::unique('customers', 'gst_number')
                ->ignore($customer->id)
                ->where(function ($query) {
                    return $query->where('gst_number', '!=', 'NA', '-');
                }),
        ],
    'phone' => [
        'required',
        'regex:/^([6-9]\d{9}|0\d{10})$/'
        //'regex:/^[6-9]\d{9}$/'
        // 'unique:customers,phone,'. $customer->id
    ],
    'email' => 'required|email'
]);

        $customer->update($request->all());
        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
