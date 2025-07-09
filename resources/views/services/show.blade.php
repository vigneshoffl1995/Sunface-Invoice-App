@extends('layouts.master')

@section('title', 'Service Details')

@section('content')
<div class="mb-3">
    <h3>Service Details</h3>
</div>

<table class="table table-striped">
    <tr>
        <th>Service Name</th>
        <td>{{ $service->service_name }}</td>
    </tr>
    <tr>
        <th>Description</th>
        <td>{{ $service->description }}</td>
    </tr>
    <tr>
        <th>HSN Code</th>
        <td>{{ $service->hsn_code }}</td>
    </tr>
    <tr>
        <th>Default Rate</th>
        <td>&#8377; {{ number_format($service->default_rate, 2) }}</td>
    </tr>
</table>

<a href="{{ route('services.index') }}" class="btn btn-secondary">Back</a>
@endsection
