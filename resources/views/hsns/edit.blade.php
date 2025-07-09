@extends('layouts.master')

@section('title', 'Edit HSN')

@section('content')
<h3>Edit HSN</h3>
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
<form action="{{ route('hsns.update', $hsn->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>HSN Code *</label>
        <input type="text" name="hsn_code" class="form-control" value="{{ $hsn->hsn_code }}" required>
    </div>
    <div class="mb-3">
        <label>Description *</label>
        <textarea name="description" class="form-control" required>{{ $hsn->description }}</textarea>
    </div>
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('hsns.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
