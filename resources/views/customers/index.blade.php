@extends('layouts.master')

@section('title', 'Customers')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Customers</h3>
    <a class="btn btn-primary" href="{{ route('customers.create') }}">Add Customer</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Company</th>
            <th>Customer Type</th>
            <th>Phone</th>
            <th>Email</th>
            <th>GST</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->company_name }}</td>
            <td>{{ $customer->customer_type }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->gst_number }}</td>
            <td>
                <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $customers->links() }}
@endsection
