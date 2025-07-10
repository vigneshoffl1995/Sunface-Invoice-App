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
                <h5 class="card-title">Paid Invoices</h5>
                <p class="fs-4">{{ $paidInvoices }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Unpaid Invoices</h5>
                <p class="fs-4">{{ $pendingInvoices }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Cancelled Invoices</h5>
                <p class="fs-4">{{ $cancelledInvoices }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-bg-dark mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Sales (Paid)</h5>
                <p class="fs-4">₹{{ number_format($totalSales, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-secondary mb-3">
            <div class="card-body">
                <h5 class="card-title">Unpaid Invoice Amount</h5>
                <p class="fs-4">₹{{ number_format($unpaidSales, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Services</h5>
                <p class="fs-4">{{ $totalServices }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Customers</h5>
                <p class="fs-4">{{ $totalCustomers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">B2B Customers</h5>
                <p class="fs-4">{{ $b2bCustomers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">B2C Customers</h5>
                <p class="fs-4">{{ $b2cCustomers }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
