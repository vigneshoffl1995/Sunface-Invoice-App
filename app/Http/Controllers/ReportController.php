<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Hsn;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $month   = $request->input('month');      // For Section 1
        $hsnMonth = $request->input('hsn_month'); // For Section 2
        $hsnCode = $request->input('hsn');        // For Section 2

        /** -------------------------------------------------
         *  SECTION 1 : MONTHLY SALES SUMMARY
         * ------------------------------------------------- */
        $monthlyQuery = Invoice::with(['customer', 'items']);

        if ($month) {
            [$year, $m] = explode('-', $month);
            $monthlyQuery->whereYear('invoice_date', $year)
                         ->whereMonth('invoice_date', $m);
        }

        $monthlyInvoices = $monthlyQuery->get();

        $totalInvoices = $monthlyInvoices->count();
        $paidInvoices  = $monthlyInvoices->where('status', 'Paid');

        $totalB2BSales = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2b')
                                      ->sum('round_total');
        $totalB2CSales = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2c')
                                      ->sum('round_total');

        $totalB2BExclgst = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2b')
                                        ->sum('sub_total');
        $totalB2CExclgst = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2c')
                                        ->sum('sub_total');

        $monthlyGST = $paidInvoices->sum(fn($inv) => $inv->cgst + $inv->sgst);

        $TotalLiability = $totalB2BExclgst + $totalB2CExclgst;
        $totalB2BCount  = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2b')->count();
        $totalB2CCount  = $paidInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2c')->count();

        $statusSummary = $monthlyInvoices->groupBy('status')->map(function ($group, $status) {
            return (object)[
                'status' => $status,
                'count'  => $group->count(),
                'total'  => $group->sum('round_total'),
            ];
        });

        /** -------------------------------------------------
         *  SECTION 2 : HSN + MONTH REPORT
         * ------------------------------------------------- */
        $hsnQuery = Invoice::with(['customer', 'items.hsn']);

        if ($hsnMonth) {
            [$year, $m] = explode('-', $hsnMonth);
            $hsnQuery->whereYear('invoice_date', $year)
                     ->whereMonth('invoice_date', $m);
        }

        if ($hsnCode) {
            $hsnQuery->whereHas('items', function ($q) use ($hsnCode) {
                $q->where('hsn_code', $hsnCode);
            });
        }

        $hsnInvoices = $hsnQuery->get();

        $filteredB2BTotal = $hsnInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2b')
                                        ->sum(fn($inv) => $inv->items->where('hsn_code', $hsnCode)
                                                                     ->sum(fn($item) => $item->quantity * $item->rate));

        $filteredB2CTotal = $hsnInvoices->filter(fn($inv) => optional($inv->customer)->customer_type === 'b2c')
                                        ->sum(fn($inv) => $inv->items->where('hsn_code', $hsnCode)
                                                                     ->sum(fn($item) => $item->quantity * $item->rate));

        $hsns = Hsn::all();

        return view('reports.sales', compact(
            // Section 1
            'month', 'totalInvoices', 'totalB2BSales', 'totalB2CSales',
            'totalB2BExclgst','totalB2CExclgst','TotalLiability',
            'totalB2BCount', 'totalB2CCount', 'statusSummary','monthlyGST',

            // Section 2
            'hsnMonth','hsnCode','hsnInvoices','hsns',
            'filteredB2BTotal','filteredB2CTotal'
        ));
    }
}
