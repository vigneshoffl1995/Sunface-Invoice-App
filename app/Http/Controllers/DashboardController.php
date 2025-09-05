<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        
        // Invoice stats
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $cancelledInvoices = Invoice::where('status', 'cancelled')->count();

        // Sales stats
        $totalSales = Invoice::where('status', 'paid')->sum('round_total');
        $unpaidSales = Invoice::where('status', 'pending')->sum('round_total');

        // Customer stats
        $totalCustomers = Customer::count();
        $b2bCustomers = Customer::where('customer_type', 'b2b')->count();
        $b2cCustomers = Customer::where('customer_type', 'b2c')->count();

        // Services
        $totalServices = Service::count();

        /**
         * 🔹 New Monthly Stats
         */
        $month = $request->input('month', now()->month);
        $year  = $request->input('year', now()->year);

        // invoices for month
        $invoices = Invoice::whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->get();

        $monthlyInvoiceValue = $invoices->sum('round_total'); // with GST
        $monthlyGST = $invoices->sum(fn($inv) => $inv->cgst + $inv->sgst);

        // expenses for month
        $expenses = Expense::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
        $monthlyExpenses = $expenses->sum('amount');

        // profit = invoices - gst - expenses
        $monthlyProfit = $monthlyInvoiceValue - $monthlyGST - $monthlyExpenses;

        // dropdown values
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        $years = range(date('Y') - 5, date('Y'));

        /**
         * 🔹 Notifications logic
         */
        $notifications = [];

        // 1. Low profit warning
        if ($monthlyProfit < 10000 && $monthlyInvoiceValue > 0) {
            $notifications[] = [
                'type' => 'warning',
                'message' => "⚠️ Low profit this month: ₹" . number_format($monthlyProfit, 2)
            ];
        }

        // 2. High expenses alert
        if ($monthlyExpenses > ($monthlyInvoiceValue * 0.5)) {
            $notifications[] = [
                'type' => 'danger',
                'message' => "🚨 Expenses are very high this month: ₹" . number_format($monthlyExpenses, 2)
            ];
        }

        // 3. Unpaid invoices older than 30 days
        $oldUnpaid = Invoice::where('status', 'pending')
            ->whereDate('invoice_date', '<', Carbon::now()->subDays(30))
            ->count();
        if ($oldUnpaid > 0) {
            $notifications[] = [
                'type' => 'info',
                'message' => "📌 You have {$oldUnpaid} unpaid invoice(s) older than 30 days."
            ];
        }

        // 4. High profit achievement
        if ($monthlyProfit > 50000) {
            $notifications[] = [
                'type' => 'success',
                'message' => "🎉 Great job! High profit this month: ₹" . number_format($monthlyProfit, 2)
            ];
        }

        return view('dashboard', compact(
            'totalInvoices',
            'paidInvoices',
            'pendingInvoices',
            'cancelledInvoices',
            'totalSales',
            'unpaidSales',
            'totalCustomers',
            'b2bCustomers',
            'b2cCustomers',
            'totalServices',
            // new
            'month',
            'year',
            'months',
            'years',
            'monthlyInvoiceValue',
            'monthlyGST',
            'monthlyExpenses',
            'monthlyProfit',
            
             // Notifications
            'notifications'
        ));
    }
}
