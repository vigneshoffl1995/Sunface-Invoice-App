@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Expense List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('expenses.index') }}" class="mb-3 d-flex gap-2">
        <select name="month" class="form-control" required>
            <option value="">Month</option>
            @foreach ($months as $key => $month)
                <option value="{{ $key }}" {{ $selectedMonth == $key ? 'selected' : '' }}>
                    {{ $month }}
                </option>
            @endforeach
        </select>

        <select name="year" class="form-control" required>
            <option value="">Year</option>
            @foreach ($years as $year)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    {{-- Summary Card for Selected Month --}}
    @if($selectedMonth && $selectedYear)
        <div class="card text-white bg-info mb-4">
            <div class="card-body">
                <h5 class="card-title">
                    Total Expenses for {{ $months[$selectedMonth] }} {{ $selectedYear }}
                </h5>
                <h3>₹ {{ number_format($expenses->sum('amount'), 2) }}</h3>
            </div>
        </div>
    @endif

    <a href="{{ route('expenses.create') }}" class="btn btn-success mb-3">+ Add Expense</a>

    {{-- Expense Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Description</th>
                <th>Amount (₹)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                    <td>{{ $expense->category }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ number_format($expense->amount, 2) }}</td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form method="POST" action="{{ route('expenses.destroy', $expense->id) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this expense?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No expenses found</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $expenses->links() }}
</div>
@endsection
