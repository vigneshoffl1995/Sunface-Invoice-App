@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Add Expense</h2>

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        @include('expenses.form')
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
