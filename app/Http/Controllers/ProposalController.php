<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\ProposalItem;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Proposal::query();

        if ($status && in_array($status, ['draft', 'sent', 'accepted', 'rejected'])) {
        $query->where('status', $status);
    }

        //$proposals = Proposal::latest()->paginate(10);
        $proposals = $query->latest()->paginate(10);
        return view('proposals.index', compact('proposals', 'status'));
        //return view('proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:255',
            'proposal_date' => 'required|date',
            'valid_until' => 'nullable|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.activity' => 'required|string|max:255',
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
        $roundTotal = floor($total); // ✅ Round-off calculation
        $roundvalue = $roundTotal - $total;

        $currentYear = date('Y');

// Get latest proposal for current year
$lastProposal = Proposal::whereYear('created_at', $currentYear)
    ->orderBy('id', 'desc')
    ->first();

// Determine the starting number
if ($lastProposal && preg_match('/PSL\/' . $currentYear . '\/(\d+)/', $lastProposal->proposal_number, $matches)) {
    $nextNumber = (int) $matches[1] + 1;
} else {
    $nextNumber = ($currentYear == '2025') ? 150 : 1;
}

// Format with leading zeros (e.g., PSL/2026/001)
$formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
$proposalNumber = 'PSL/' . $currentYear . '/' . $formattedNumber;

        $proposal = Proposal::create([
            //'proposal_number' => 'PROP-' . time(),
            'proposal_number' => $proposalNumber,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'proposal_date' => $validated['proposal_date'],
            'valid_until' => $validated['valid_until'],
            'notes' => $validated['notes'],
            'sub_total' => $subTotal,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'total' => $total,
            'status' => 'draft',
            'round_total' => $roundTotal, // ✅ Save to DB
            'round_value' => $roundvalue,
        ]);

        foreach ($validated['items'] as $item) {
            $proposal->items()->create([
                'activity' => $item['activity'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'amount' => $item['quantity'] * $item['rate'],
            ]);
        }

        return redirect()->route('proposals.index')->with('success', 'Proposal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal)
    {
        $proposal->load('items');
        return view('proposals.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        $proposal->load('items');
        return view('proposals.edit', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
        'customer_name' => 'required|string|max:150',
        'customer_phone' => 'required|string|max:20',
        'customer_address' => 'nullable|string|max:255',
        'proposal_date' => 'required|date',
        'valid_until' => 'nullable|date',
        'notes' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.activity' => 'required|string|max:255',
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

    $roundTotal = floor($total); // ✅ Round-off calculation
    $roundvalue = $roundTotal - $total;

    $proposal->update([
        'customer_name' => $validated['customer_name'],
        'customer_phone' => $validated['customer_phone'],
        'customer_address' => $validated['customer_address'],
        'proposal_date' => $validated['proposal_date'],
        'valid_until' => $validated['valid_until'],
        'notes' => $validated['notes'],
        'sub_total' => $subTotal,
        'cgst' => $cgst,
        'sgst' => $sgst,
        'total' => $total,
        'round_total' => $roundTotal, // ✅ Save to DB
        'round_value' => $roundvalue,
    ]);

    // clear existing items
    $proposal->items()->delete();

    // recreate items
    foreach ($validated['items'] as $item) {
        $proposal->items()->create([
            'activity' => $item['activity'],
            'quantity' => $item['quantity'],
            'rate' => $item['rate'],
            'amount' => $item['quantity'] * $item['rate'],
        ]);
    }

    return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }

    public function updateStatus(Request $request, Proposal $proposal)
{
    $request->validate([
        'status' => 'required|in:draft,sent,accepted,rejected'
    ]);

    $proposal->status = $request->status;
    $proposal->save();

    return redirect()->route('proposals.index')->with('success', 'Proposal status updated successfully.');
}

public function print($id)
{
    $proposal = Proposal::with('items')->findOrFail($id);
    return view('proposals.print', compact('proposal'));
}


}
