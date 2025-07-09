@extends('layouts.master')

@section('title', 'Sales Reports')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <h3>Sales Report</h3>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <input type="month" name="month" class="form-control" value="{{ $month }}">
    </div>
    <div class="col-md-3">
        <select name="hsn" class="form-select">
            <option value="">-- All HSN --</option>
            @foreach($hsns as $h)
                <option value="{{ $h->id }}" {{ $hsnCode == $h->id ? 'selected' : '' }}>
                    {{ $h->hsn_code }} - {{ $h->description }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary" type="submit">Filter</button>
        <a href="{{ route('reports.sales') }}" class="btn btn-secondary">Clear</a>
    </div>
</form>

{{-- Summary Cards --}}
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Invoices</h5>
                <p class="card-text fs-4">{{ $totalInvoices }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Paid B2B Sales (incl. GST)</h5>
                <p class="card-text fs-4">{{ number_format($totalB2BSales, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Paid B2C Sales (incl. GST)</h5>
                <p class="card-text fs-4">{{ number_format($totalB2CSales, 2) }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Status Summary --}}
<h5>Status Summary</h5>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Status</th>
            <th>Count</th>
            <th>Total (₹)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($statusSummary as $status)
        <tr>
            <td>{{ ucfirst($status->status) }}</td>
            <td>{{ $status->count }}</td>
            <td>{{ number_format($status->total, 2) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No data found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Filtered subtotal (no GST) --}}
@if($month || $hsnCode)
<h5 class="mt-4">Filtered Subtotal (excluding GST)</h5>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Type</th>
            <th>Subtotal (₹)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>B2B</td>
            <td>{{ number_format($filteredB2BTotal, 2) }}</td>
        </tr>
        <tr>
            <td>B2C</td>
            <td>{{ number_format($filteredB2CTotal, 2) }}</td>
        </tr>
    </tbody>
</table>
@endif
@endsection
