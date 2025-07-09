@extends('layouts.master')

@section('title', 'Create Invoice')

@section('content')
<div class="mb-3">
    <h3>Create Invoice</h3>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Please fix the following issues:
    <ul>
        @foreach ($errors->all() as $error) 
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('invoices.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Customer *</label>
        <select name="customer_id" class="form-select" required>
            <option value="">-- Select Customer --</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->company_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label>Invoice Date *</label>
            <input type="date" name="invoice_date" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label>Validity Date</label>
            <input type="date" name="valid_until" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label>Notes</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>

    <hr>

    <h5>Line Items</h5>
    <table class="table table-bordered" id="itemsTable">
        <thead class="table-secondary">
            <tr>
                <th>Activity</th>
                <th>HSN</th>
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
            <!-- dynamic rows will be appended here -->
        </tbody>
    </table>

    <div class="row mb-3">
        <div class="col-md-3">
            <label>Subtotal (₹)</label>
            <input type="text" name="sub_total" class="form-control" id="sub_total" readonly>
        </div>
        <div class="col-md-3">
            <label>CGST 9% (₹)</label>
            <input type="text" name="cgst" class="form-control" id="cgst" readonly>
        </div>
        <div class="col-md-3">
            <label>SGST 9% (₹)</label>
            <input type="text" name="sgst" class="form-control" id="sgst" readonly>
        </div>
        <div class="col-md-3">
            <label>Total (₹)</label>
            <input type="text" name="total" class="form-control" id="grand_total" readonly>
        </div>
    </div>

    <button class="btn btn-primary">Save Invoice</button>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

@section('scripts')
<script>
let hsns = @json($hsns);
let itemIndex = 0;

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
            <input type="text" name="items[${itemIndex}][activity]" class="form-control" required style="width: 450px;">
        </td>
        <td>
            <select name="items[${itemIndex}][hsn_id]" class="form-select" required>
                <option value="">Select HSN</option>
                ${hsns.map(h => `<option value="${h.id}">${h.hsn_code} - ${h.description}</option>`).join("")}
            </select>
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
