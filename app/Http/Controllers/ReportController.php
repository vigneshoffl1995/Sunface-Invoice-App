<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Hsn;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $month    = $request->input('month');
        //$hsnCode  = $request->input('hsn');
        $hsnCode = $request->input('hsn');

        $query = Invoice::with(['customer', 'items.hsn']);

        // Apply month filter
        if ($month) {
            [$year, $m] = explode('-', $month);
            $query->whereYear('invoice_date', $year)
                  ->whereMonth('invoice_date', $m);
        }

        // Apply HSN filter
        // if ($hsnCode) {
        //     $query->whereHas('items.hsn', function ($q) use ($hsnCode) {
        //         $q->where('hsn_code', $hsnCode);
        //     });
        // }

        if ($hsnCode) {
    $query->whereHas('items', function ($q) use ($hsnCode) {
        $q->where('hsn_code', $hsnCode);
    });
}

        $invoices = $query->get();

        // Total Invoices (All)
        $totalInvoices = $invoices->count();

        // Only Paid invoices for GST-included calculations
        $paidInvoices = $invoices->where('status', 'paid');

        $totalB2BSales = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2b')
                                      ->sum('total');

        $totalB2CSales = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2c')
                                      ->sum('total');

        $totalB2BCount = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2b')->count();
        $totalB2CCount = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2c')->count();

        // Status Summary
        $statusSummary = $invoices->groupBy('status')->map(function ($group, $status) {
            return (object)[
                'status' => $status,
                'count'  => $group->count(),
                'total'  => $group->sum('total'),
            ];
        });

        // Subtotals without GST (filtered only)
        $filteredB2BTotal = $invoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2b')
                                     ->sum(fn($inv) => $inv->items->sum(fn($item) => $item->quantity * $item->rate));

        $filteredB2CTotal = $invoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2c')
                                     ->sum(fn($inv) => $inv->items->sum(fn($item) => $item->quantity * $item->rate));

        $hsns = Hsn::all();

        return view('reports.sales', compact(
            'month', 'hsnCode', 'hsns',
            'totalInvoices', 'totalB2BSales', 'totalB2CSales',
            'totalB2BCount', 'totalB2CCount',
            'statusSummary',
            'filteredB2BTotal', 'filteredB2CTotal'
        ));
    }
}
