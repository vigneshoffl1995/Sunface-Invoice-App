@extends('layouts.master')

@section('title', 'Create Service')

@section('content')
<div class="mb-3">
    <h3>Add Service</h3>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Fix these issues:<br><br>
        <ul>
            @foreach ($errors->all() as $error) 
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('services.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Service Name *</label>
        <input type="text" name="service_name" class="form-control" required value="{{ old('service_name') }}">
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
    </div>
    <div class="mb-3">
        <label>HSN Code *</label>
        <input type="text" name="hsn_code" class="form-control" required value="{{ old('hsn_code') }}">
    </div>
    <div class="mb-3">
        <label>Default Rate (₹) *</label>
        <input type="number" name="default_rate" class="form-control" step="0.01" required value="{{ old('default_rate') }}">
    </div>
    <button class="btn btn-success">Save</button>
    <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
