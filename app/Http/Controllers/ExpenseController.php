<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query();

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(10);

        return view('expenses.index', [
            'expenses' => $expenses,
            'selectedMonth' => $request->month,
            'selectedYear' => $request->year,
            'months' => [
                '01' => 'January', '02' => 'February', '03' => 'March',
                '04' => 'April', '05' => 'May', '06' => 'June',
                '07' => 'July', '08' => 'August', '09' => 'September',
                '10' => 'October', '11' => 'November', '12' => 'December',
            ],
            'years' => range(date('Y'), date('Y') - 5),
        ]);
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        Expense::destroy($id);
        return back()->with('success', 'Expense deleted successfully.');
    }
}
