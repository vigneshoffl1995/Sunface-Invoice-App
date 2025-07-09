@extends('layouts.master')

@section('content')
<div class="mb-3">
    <h3>Dashboard</h3>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Invoices</h5>
                <p class="fs-4">{{ $totalInvoices }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Sales (₹)</h5>
                <p class="fs-4">{{ number_format($totalSales, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Customers</h5>
                <p class="fs-4">{{ $totalCustomers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Services</h5>
                <p class="fs-4">{{ $totalServices }}</p>
            </div>
        </div>
    </div>
</div>

<h5>Recent Invoices</h5>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Invoice Number</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total (₹)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recentInvoices as $invoice)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->customer->name }}</td>
            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y') }}</td>
            <td>{{ number_format($invoice->total, 2) }}</td>
            <td>
                @if($invoice->status == 'paid')
                    <span class="badge bg-success">Paid</span>
                @elseif($invoice->status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @else
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">No recent invoices found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
