@extends('layouts.master')
@section('title', 'Customer Details')
@section('content')
<div class="mb-3">
    <h3>Customer Details</h3>
</div>

<table class="table table-striped">
    <tr>
        <th>Name</th>
        <td>{{ $customer->name }}</td>
    </tr>
    <tr>
        <th>Company</th>
        <td>{{ $customer->company_name }}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{ $customer->address }}</td>
    </tr>
    <tr>
        <th>GST</th>
        <td>{{ $customer->gst_number }}</td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>{{ $customer->phone }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $customer->email }}</td>
    </tr>
</table>

<a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
@endsection
