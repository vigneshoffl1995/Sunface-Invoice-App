@extends('layouts.master')

@section('title', 'Edit Proposal')

@section('content')
<div class="mb-3">
    <h3>Edit Proposal</h3>
</div>

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

<form action="{{ route('proposals.update', $proposal) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Customer Name *</label>
        <input type="text" name="customer_name" class="form-control" required value="{{ $proposal->customer_name }}">
    </div>

    <div class="mb-3">
        <label>Customer Address</label>
        <textarea name="customer_address" class="form-control">{{ $proposal->customer_address }}</textarea>
    </div>

    <div class="mb-3">
        <label>Customer Phone *</label>
        <input type="text" name="customer_phone" class="form-control" required value="{{ $proposal->customer_phone }}">
    </div>

    <div class="mb-3">
        <label>Proposal Date *</label>
        <input type="date" name="proposal_date" class="form-control" required value="{{ $proposal->proposal_date }}">
    </div>

    <div class="mb-3">
        <label>Valid Until</label>
        <input type="date" name="valid_until" class="form-control" value="{{ $proposal->valid_until }}">
    </div>

    <div class="mb-3">
        <label>Notes</label>
        <textarea name="notes" class="form-control">{{ $proposal->notes }}</textarea>
    </div>

    <h5>Line Items</h5>
    <table class="table table-bordered" id="itemsTable">
        <thead class="table-secondary">
            <tr>
                <th>Activity</th>
                <th>Qty</th>
                <th>Rate (₹)</th>
                <th>Amount (₹)</th>
                <th>
                    <button type="button" class="btn btn-success btn-sm" id="addItem">
                        <i class="bi bi-plus"></i> Add
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($proposal->items as $index => $item)
            <tr>
                <td>
                    <input type="text" name="items[{{ $index }}][activity]" class="form-control" required value="{{ $item->activity }}">
                </td>
                <td>
                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control qty" min="1" value="{{ $item->quantity }}">
                </td>
                <td>
                    <input type="number" name="items[{{ $index }}][rate]" class="form-control rate" step="0.01" value="{{ $item->rate }}">
                </td>
                <td>
                    <input type="text" class="form-control amount" readonly value="{{ $item->amount }}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm removeItem">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row mb-3">
        <div class="col-md-3">
            <label>Subtotal (₹)</label>
            <input type="text" name="sub_total" class="form-control" id="sub_total" readonly value="{{ $proposal->sub_total }}">
        </div>
        <div class="col-md-3">
            <label>CGST 9% (₹)</label>
            <input type="text" name="cgst" class="form-control" id="cgst" readonly value="{{ $proposal->cgst }}">
        </div>
        <div class="col-md-3">
            <label>SGST 9% (₹)</label>
            <input type="text" name="sgst" class="form-control" id="sgst" readonly value="{{ $proposal->sgst }}">
        </div>
        <div class="col-md-3">
            <label>Total (₹)</label>
            <input type="text" name="total" class="form-control" id="grand_total" readonly value="{{ $proposal->total }}">
        </div>
    </div>

    <button class="btn btn-primary">Update Proposal</button>
    <a href="{{ route('proposals.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

@section('scripts')
<script>
let itemIndex = {{ $proposal->items->count() }};

function recalculateTotals() {
    let subtotal = 0;
    $("#itemsTable tbody tr").each(function(){
        const qty = parseFloat($(this).find(".qty").val() || 0);
        const rate = parseFloat($(this).find(".rate").val() || 0);
        const amount = qty * rate;
        $(this).find(".amount").val(amount.toFixed(2));
        subtotal += amount;
    });
    $("#sub_total").val(subtotal.toFixed(2));
    const cgst = subtotal * 0.09;
    const sgst = subtotal * 0.09;
    const grand_total = subtotal + cgst + sgst;
    $("#cgst").val(cgst.toFixed(2));
    $("#sgst").val(sgst.toFixed(2));
    $("#grand_total").val(grand_total.toFixed(2));
}

$("#addItem").click(function(){
    const row = `<tr>
        <td>
            <input type="text" name="items[${itemIndex}][activity]" class="form-control" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][quantity]" class="form-control qty" min="1" value="1">
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][rate]" class="form-control rate" step="0.01">
        </td>
        <td>
            <input type="text" class="form-control amount" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm removeItem">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>`;
    $("#itemsTable tbody").append(row);
    itemIndex++;
});

$("#itemsTable").on("click", ".removeItem", function(){
    $(this).closest("tr").remove();
    recalculateTotals();
});

$("#itemsTable").on("input", ".qty, .rate", function(){
    recalculateTotals();
});
</script>
@endsection
