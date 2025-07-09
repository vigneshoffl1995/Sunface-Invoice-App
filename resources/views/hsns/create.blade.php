@extends('layouts.master')

@section('title', 'Create HSN')

@section('content')
<h3>Add HSN</h3>
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Please fix these issues:
    <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('hsns.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>HSN Code *</label>
        <input type="text" name="hsn_code" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description *</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>
    <button class="btn btn-primary">Save</button>
    <a href="{{ route('hsns.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
