<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private const CATEGORIES = [
        'Rent', 'Utilities', 'Equipment', 'Maintenance',
        'Supplies', 'Marketing', 'Cleaning', 'Other',
    ];

    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;

        $query = Expense::where('gym_id', $gymId);

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by month/year
        if ($request->filled('month')) {
            $query->whereMonth('expense_date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('expense_date', $request->year);
        } else {
            $query->whereYear('expense_date', now()->year);
        }

        $expenses  = $query->latest('expense_date')->paginate(15);
        $total     = $query->sum('amount');

        // Summary by category (current year unless filtered)
        $summaryQuery = Expense::where('gym_id', $gymId);
        if ($request->filled('year')) {
            $summaryQuery->whereYear('expense_date', $request->year);
        } else {
            $summaryQuery->whereYear('expense_date', now()->year);
        }
        if ($request->filled('month')) {
            $summaryQuery->whereMonth('expense_date', $request->month);
        }
        $categoryTotals = $summaryQuery->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $grandTotal = $categoryTotals->sum('total');

        $categories = self::CATEGORIES;
        $years      = Expense::where('gym_id', $gymId)
            ->selectRaw('YEAR(expense_date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        if (empty($years)) {
            $years = [now()->year];
        }

        return view('gym.expenses.index', compact(
            'expenses', 'total', 'categoryTotals', 'grandTotal', 'categories', 'years'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'amount'       => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'notes'        => 'nullable|string|max:500',
        ]);

        $validated['gym_id'] = $request->user()->gym_id;

        Expense::create($validated);
        return redirect()->back()->with('success', 'Expense added successfully.');
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->gym_id !== $request->user()->gym_id) abort(403);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'amount'       => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'notes'        => 'nullable|string|max:500',
        ]);

        $expense->update($validated);
        return redirect()->back()->with('success', 'Expense updated successfully.');
    }

    public function destroy(Request $request, Expense $expense)
    {
        if ($expense->gym_id !== $request->user()->gym_id) abort(403);
        $expense->delete();
        return redirect()->back()->with('success', 'Expense deleted successfully.');
    }
}
