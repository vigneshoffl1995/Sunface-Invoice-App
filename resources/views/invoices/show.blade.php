@extends('layouts.master')

@section('title', 'Invoice Details')

@section('content')
<div class="mb-3">
    <h3>Invoice #{{ $invoice->invoice_number }}</h3>
    <small class="text-muted">Status: <strong>{{ ucfirst($invoice->status) }}</strong></small>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Customer Details</h5>
        <p>
            <strong>{{ $invoice->customer->name }}</strong><br>
            {{ $invoice->customer->company_name }}<br>
            {{ $invoice->customer->address }}<br>
            {{ $invoice->customer->email }}<br>
            {{ $invoice->customer->phone }}
        </p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Invoice Details</h5>
        <p>
            <strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('d-m-Y') }} <br>
            <strong>Validity:</strong> {{ optional($invoice->valid_until)->format('d-m-Y') ?? 'N/A' }}
        </p>
    </div>
</div>

<div class="table-responsive mb-4">
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Activity (Service)</th>
                <th>HSN</th>
                <th>Qty</th>
                <th>Rate (₹)</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->activity }}</td>
                    <td>{{ $item->hsn_code }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->rate, 2) }}</td>
                    <td>{{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="row mb-3">
    <div class="col-md-3">
        <strong>Subtotal:</strong> ₹{{ number_format($invoice->sub_total, 2) }}
    </div>
    <div class="col-md-3">
        <strong>CGST (9%):</strong> ₹{{ number_format($invoice->cgst, 2) }}
    </div>
    <div class="col-md-3">
        <strong>SGST (9%):</strong> ₹{{ number_format($invoice->sgst, 2) }}
    </div>
    <div class="col-md-3">
        <strong>Total:</strong> ₹{{ number_format($invoice->total, 2) }}
    </div>
</div>

@if($invoice->notes)
<div class="alert alert-info mt-3">
    <strong>Notes:</strong><br>
    {{ $invoice->notes }}
</div>
@endif

<div class="mt-4">
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
</div>
<a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="btn btn-primary">
    Download / Print
</a>
@endsection
