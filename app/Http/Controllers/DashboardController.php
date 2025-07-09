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
        $totalInvoices = Invoice::count();
        $totalSales = Invoice::sum('total');
        $totalCustomers = Customer::count();
        $totalServices = Service::count();

        $recentInvoices = Invoice::latest()->take(5)->with('customer')->get();

        return view('dashboard', compact(
            'totalInvoices',
            'totalSales',
            'totalCustomers',
            'totalServices',
            'recentInvoices'
        ));
    }
}
