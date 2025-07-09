@extends('layouts.master')

@section('title', 'Proposals')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Proposals</h3>
    <a class="btn btn-primary" href="{{ route('proposals.create') }}">
        <i class="bi bi-plus"></i> New Proposal
    </a>
</div>

<div class="mb-3">
    <a href="{{ route('proposals.index') }}" class="btn btn-outline-secondary btn-sm {{ request('status') == null ? 'active' : '' }}">
        All
    </a>
    <a href="{{ route('proposals.index', ['status' => 'draft']) }}" class="btn btn-outline-dark btn-sm {{ request('status') == 'draft' ? 'active' : '' }}">
        Draft
    </a>
    <a href="{{ route('proposals.index', ['status' => 'sent']) }}" class="btn btn-outline-primary btn-sm {{ request('status') == 'sent' ? 'active' : '' }}">
        Sent
    </a>
    <a href="{{ route('proposals.index', ['status' => 'accepted']) }}" class="btn btn-outline-success btn-sm {{ request('status') == 'accepted' ? 'active' : '' }}">
        Accepted
    </a>
    <a href="{{ route('proposals.index', ['status' => 'rejected']) }}" class="btn btn-outline-danger btn-sm {{ request('status') == 'rejected' ? 'active' : '' }}">
        Rejected
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Proposal Number</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total (₹)</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($proposals as $proposal)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $proposal->proposal_number }}</td>
            <td>{{ $proposal->customer_name }}</td>
            <td>{{ \Carbon\Carbon::parse($proposal->proposal_date)->format('d-M-Y') }}</td>
            <td>{{ number_format($proposal->total, 2) }}</td>
            <td>
                <form action="{{ route('proposals.updateStatus', $proposal->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="draft" {{ $proposal->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ $proposal->status == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="accepted" {{ $proposal->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ $proposal->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </form>
            </td>
            <td>
                <a href="{{ route('proposals.show', $proposal->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i> View
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No proposals found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- {{ $proposals->links() }} -->
{{ $proposals->appends(request()->query())->links() }}
@endsection
