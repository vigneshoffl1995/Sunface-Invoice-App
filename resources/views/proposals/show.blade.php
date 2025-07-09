@extends('layouts.master')

@section('title', 'Proposal Details')

@section('content')
<div class="mb-3 d-flex justify-content-between">
    <h3>Proposal Details</h3>
    
</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Proposal #{{ $proposal->proposal_number }}</h5>
        <p><strong>Customer Name:</strong> {{ $proposal->customer_name }}</p>
        <p><strong>Phone:</strong> {{ $proposal->customer_phone }}</p>
        @if($proposal->customer_address)
        <p><strong>Address:</strong> {{ $proposal->customer_address }}</p>
        @endif
        <p><strong>Proposal Date:</strong> {{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d M Y') }}</p>
        <p><strong>Valid Until:</strong> {{ $proposal->valid_until ? \Carbon\Carbon::parse($proposal->valid_until)->format('d M Y') : 'N/A' }}</p>
        <p><strong>Status:</strong> <span class="badge bg-info text-dark text-uppercase">{{ $proposal->status }}</span></p>
        <p><strong>Notes:</strong><br>{{ $proposal->notes ?? '-' }}</p>
    </div>
</div>

<h5>Proposal Items</h5>
<table class="table table-bordered">
    <thead class="table-secondary">
        <tr>
            <th>#</th>
            <th>Activity</th>
            <th>Quantity</th>
            <th>Rate (₹)</th>
            <th>Amount (₹)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proposal->items as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->activity }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->rate, 2) }}</td>
            <td>{{ number_format($item->amount, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="text-end mt-3">
    <p><strong>Subtotal:</strong> ₹{{ number_format($proposal->sub_total, 2) }}</p>
    <p><strong>CGST (9%):</strong> ₹{{ number_format($proposal->cgst, 2) }}</p>
    <p><strong>SGST (9%):</strong> ₹{{ number_format($proposal->sgst, 2) }}</p>
    <h5><strong>Total:</strong> ₹{{ number_format($proposal->total, 2) }}</h5>
</div>

<div class="mt-4">
    <a href="{{ route('proposals.index') }}" class="btn btn-secondary">Back</a>
</div>
<a href="{{ route('proposal.print', $proposal->id) }}" target="_blank" class="btn btn-primary">
    Download / Print
</a>
@endsection
