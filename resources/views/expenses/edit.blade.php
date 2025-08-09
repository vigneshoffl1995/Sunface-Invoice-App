@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Edit Expense</h2>

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf @method('PUT')
        @include('expenses.form', ['expense' => $expense])
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
