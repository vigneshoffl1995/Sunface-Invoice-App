@extends('layouts.master')

@section('title', 'Services')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Services</h3>
    <a class="btn btn-primary" href="{{ route('services.create') }}">Add Service</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Service</th>
            <th>Description</th>
            <th>HSN Code</th>
            <th>Default Rate</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($services as $service)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $service->service_name }}</td>
            <td>{{ $service->description }}</td>
            <td>{{ $service->hsn_code }}</td>
            <td>&#8377; {{ number_format($service->default_rate, 2) }}</td>
            <td>
                <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $services->links() }}
@endsection
