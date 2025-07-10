<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
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
            'totalServices'
        ));
    }
}
