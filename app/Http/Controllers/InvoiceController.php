<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Hsn;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $from = $request->query('from');
        $to = $request->query('to');

        $invoices = Invoice::with('customer')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($from, fn($q) => $q->whereDate('invoice_date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('invoice_date', '<=', $to))
            ->orderBy('invoice_date', 'desc')
            ->paginate(10);

        return view('invoices.index', compact('invoices', 'status', 'from', 'to'));
    }

    public function create()
    {
        $customers = Customer::all();
        $hsns = Hsn::all();
        return view('invoices.create', compact('customers', 'hsns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.activity' => 'required|string|max:255',
            //'items.*.hsn_code' => 'required|string|max:20',
            'items.*.hsn_id' => 'required|exists:hsns,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.rate' => 'required|numeric|min:0',
        ]);

        $subTotal = 0;
        foreach ($validated['items'] as $item) {
            $subTotal += $item['quantity'] * $item['rate'];
        }
        $cgst = $subTotal * 0.09;
        $sgst = $subTotal * 0.09;
        $total = $subTotal + $cgst + $sgst;



        // $latestInvoice = Invoice::latest()->first();
        // $nextNumber = $latestInvoice ? $latestInvoice->id + 1 : 1;
        // $invoiceNumber = 'ST/' . date('Y') . '/' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $currentYear = date('Y');

// find the last invoice for this year
        $lastInvoice = Invoice::whereYear('invoice_date', $currentYear)->latest('id')->first();

// determine the next sequence
        $nextNumber = $lastInvoice ? intval(explode('/', $lastInvoice->invoice_number)[2]) + 1 : 1;

        //$invoiceNumber = 'ST/' . $currentYear . '/' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        $invoiceNumber = 'ST/25-26/'. str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
           // 'invoice_number' => 'ST/' . time(),
            'invoice_number' => $invoiceNumber,
            'customer_id' => $validated['customer_id'],
            'invoice_date' => $validated['invoice_date'],
            'valid_until' => $validated['valid_until'],
            'notes' => $validated['notes'],
            'sub_total' => $subTotal,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'total' => $total,
        ]);

        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'activity' => $item['activity'],
                'hsn_code' => $item['hsn_id'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'amount' => $item['quantity'] * $item['rate'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        $invoice->load('items');
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        return redirect()->back()->with('info', 'Invoice editing is under development.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('customer', 'items');
        return view('invoices.print', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $invoice->status = $request->status;
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice status updated successfully.');
    }
}
