@extends('layouts.master')

@section('title', 'Edit Customer')

@section('content')
<div class="mb-3">
    <h3>Edit Customer</h3>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Please fix these issues:<br><br>
        <ul>
            @foreach ($errors->all() as $error) 
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('customers.update', $customer) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name *</label>
        <input type="text" name="name" class="form-control" required value="{{ $customer->name }}">
    </div>
    <div class="mb-3">
        <label>Company Name</label>
        <input type="text" name="company_name" class="form-control" value="{{ $customer->company_name }}">
    </div>
    <div class="mb-3">
        <label>Customer Type *</label>
        <select name="customer_type" class="form-select" required>
            <option value="b2b" {{ $customer->customer_type === 'b2b' ? 'selected' : '' }}>B2B (Business with GST)</option>
            <option value="b2c" {{ $customer->customer_type === 'b2c' ? 'selected' : '' }}>B2C (Consumer without GST)</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Address *</label>
        <textarea name="address" class="form-control" required>{{ $customer->address }}</textarea>
    </div>
    <div class="mb-3">
        <label>GST Number</label>
        <input type="text" name="gst_number" class="form-control" value="{{ $customer->gst_number }}">
    </div>
    <div class="mb-3">
        <label>Phone *</label>
        <input type="text" name="phone" class="form-control" required value="{{ $customer->phone }}">
    </div>
    <div class="mb-3">
        <label>Email *</label>
        <input type="email" name="email" class="form-control" required value="{{ $customer->email }}">
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
