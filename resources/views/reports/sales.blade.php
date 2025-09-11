@extends('layouts.master')

@section('title', 'Sales Reports')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <h3>Sales Report</h3>
</div>

{{-- ===========================
     SECTION 1 : MONTHLY SALES
   =========================== --}}
<h4>Monthly Sales Summary</h4>
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <input type="month" name="month" class="form-control" value="{{ $month }}">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary" type="submit">Filter</button>
        <a href="{{ route('reports.sales') }}" class="btn btn-secondary">Clear</a>
    </div>
</form>

<div class="row mb-3">
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5>Total Invoices</h5>
                <p class="fs-4">{{ $totalInvoices }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5>B2B Sales (incl. GST)</h5>
                <p class="fs-4">{{ number_format($totalB2BSales,2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info mb-3">
            <div class="card-body">
                <h5>B2C Sales (incl. GST)</h5>
                <p class="fs-4">{{ number_format($totalB2CSales,2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning mb-3">
            <div class="card-body">
                <h5>B2B Sales (Excl. GST)</h5>
                <p class="fs-4">{{ number_format($totalB2BExclgst,2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info mb-3">
            <div class="card-body">
                <h5>B2C Sales (Excl. GST)</h5>
                <p class="fs-4">{{ number_format($totalB2CExclgst,2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5>Total GST</h5>
                <p class="fs-4">{{ number_format($monthlyGST,2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5>Total Liability (Excl. GST)</h5>
                <p class="fs-4">{{ number_format($TotalLiability,2) }}</p>
            </div>
        </div>
    </div>
</div>

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


{{-- ===========================
     SECTION 2 : HSN REPORT
   =========================== --}}
<hr>
<h4>HSN Based Sales Report</h4>
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <input type="month" name="hsn_month" class="form-control" value="{{ $hsnMonth }}">
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

@if($hsnMonth || $hsnCode)
    <h5>Filtered Subtotal (Excl. GST)</h5>
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

    <h5>Detailed Invoices</h5>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Invoice #</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Status</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hsnInvoices as $inv)
            <tr>
                <td>{{ $inv->invoice_number }}</td>
                <td>{{ $inv->invoice_date }}</td>
                <td>{{ optional($inv->customer)->name }}</td>
                <td>{{ optional($inv->customer)->customer_type }}</td>
                <td>{{ $inv->status }}</td>
                <td>{{ number_format($inv->round_total, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No invoices found for selected filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endif
@endsection
