@extends('layouts.master')

@section('title', 'HSN Codes')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>HSN Codes</h3>
    <a href="{{ route('hsns.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add HSN
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>HSN Code</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($hsns as $hsn)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $hsn->hsn_code }}</td>
            <td>{{ $hsn->description }}</td>
            <td>
                <a href="{{ route('hsns.edit', $hsn->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('hsns.destroy', $hsn->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this HSN?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No HSN codes found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $hsns->links() }}
@endsection
