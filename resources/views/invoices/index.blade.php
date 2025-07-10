@extends('layouts.master')

@section('title', 'Invoices')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Invoices</h3>
    <a class="btn btn-primary" href="{{ route('invoices.create') }}">
        <i class="bi bi-plus"></i> New Invoice
    </a>
</div>

<div class="mb-3">
    <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary btn-sm {{ $status == null ? 'active' : '' }}">
        All
    </a>
    <a href="{{ route('invoices.index', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm {{ $status == 'pending' ? 'active' : '' }}">
        Pending
    </a>
    <a href="{{ route('invoices.index', ['status' => 'paid']) }}" class="btn btn-outline-success btn-sm {{ $status == 'paid' ? 'active' : '' }}">
        Paid
    </a>
    <a href="{{ route('invoices.index', ['status' => 'cancelled']) }}" class="btn btn-outline-danger btn-sm {{ $status == 'cancelled' ? 'active' : '' }}">
        Cancelled
    </a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="from" class="form-control" value="{{ $from }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="to" class="form-control" value="{{ $to }}">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary" type="submit">Filter</button>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Clear</a>
    </div>
</form>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Invoice Number</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Subtotal (₹)</th>
            <th>Total (₹)</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($invoices as $invoice)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->customer->name }}</td>
            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y') }}</td>
            <td>{{ number_format($invoice->sub_total, 2) }}</td>
            <td>{{ number_format($invoice->total, 2) }}</td>
            <td>
    <form action="{{ route('invoices.updateStatus', $invoice->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="pending" {{ $invoice->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ $invoice->status == 'Paid' ? 'selected' : '' }}>Paid</option>
            <option value="cancelled" {{ $invoice->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </form>
</td>
            <td>
                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> View
                </a>
                {{-- Later you can add edit, delete here if you want --}}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">No invoices found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $invoices->links() }}
@endsection
