@extends('layouts.master')

@section('title', 'Create Customer')

@section('content')
<div class="mb-3">
    <h3>Add Customer</h3>
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

<form action="{{ route('customers.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name *</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
    </div>
    <div class="mb-3">
        <label>Company Name</label>
        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}">
    </div>
    <div class="mb-3">
        <label>Customer Type</label>
            <select name="customer_type" class="form-select" required>
                <option value="b2b">B2B (Business with GST)</option>
                <option value="b2c">B2C (Consumer without GST)</option>
            </select>
    </div>
    <div class="mb-3">
        <label>Address *</label>
        <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
    </div>
    <div class="mb-3">
        <label>GST Number</label>
        <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}">
    </div>
    <div class="mb-3">
        <label>Phone *</label>
        <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
    </div>
    <div class="mb-3">
        <label>Email *</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
    </div>
    <button class="btn btn-success">Save</button>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
