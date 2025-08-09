@csrf
<div class="mb-3">
    <label for="expense_type">Expense Type</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $expense->category ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="amount">Amount</label>
    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $expense->amount ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="date">Date</label>
    <input type="date" name="date" class="form-control" value="{{ old('date', $expense->date ?? date('Y-m-d')) }}" required>
</div>

<div class="mb-3">
    <label for="remarks">Remarks</label>
    <textarea name="description" class="form-control">{{ old('remarks', $expense->description ?? '') }}</textarea>
</div>
