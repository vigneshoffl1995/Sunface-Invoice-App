@extends('layouts.master')

@section('content')

@if (!empty($notifications))
    <div id="notificationBar" class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
        <span id="notificationMessage">{!! $notifications[0]['message'] !!}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="mb-3">
    <h3>Monthly Report</h3>
</div>

<!-- Month/Year Filter -->
<form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2 mb-3">
    <select name="month" class="form-control" required>
        @foreach ($months as $key => $m)
            <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>{{ $m }}</option>
        @endforeach
    </select>

    <select name="year" class="form-control" required>
        @foreach ($years as $y)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary">Filter</button>
</form>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Turn-Over (₹)</h5>
                <p class="fs-4">{{ number_format($monthlyInvoiceValue, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total GST (₹)</h5>
                <p class="fs-4">{{ number_format($monthlyGST, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Expenses (₹)</h5>
                <p class="fs-4">{{ number_format($monthlyExpenses, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Profit (₹)</h5>
                <p class="fs-4">{{ number_format($monthlyProfit, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="mb-3">
    <h3>Over All Report</h3>
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
                <h5 class="card-title">Unpaid Invoice</h5>
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

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let notifications = @json($notifications);
        let currentIndex = 0;
        let notifBar = document.getElementById("notificationBar");
        let notifMessage = document.getElementById("notificationMessage");

        if (notifications.length > 1) {
            setInterval(() => {
                currentIndex = (currentIndex + 1) % notifications.length;
                notifBar.className = `alert alert-${notifications[currentIndex].type} alert-dismissible fade show shadow-sm`;
                notifMessage.innerHTML = notifications[currentIndex].message;
            }, 5000); // change every 5 seconds
        }
    });
</script>
@endsection

@endsection
