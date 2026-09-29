<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('user')
            ->latest('expense_date')
            ->latest('id');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('paid_to', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Payment method filter
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Date filter
        if ($request->filled('date_from')) {
            $query->whereDate('expense_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('expense_date', '<=', $request->date_to);
        }

        $expenses = $query->paginate(15)->withQueryString();

        // Statistics
        $totalExpenses = Expense::sum('amount');

        $todayExpenses = Expense::whereDate(
            'expense_date',
            today()
        )->sum('amount');

        $monthExpenses = Expense::whereMonth(
            'expense_date',
            now()->month
        )
            ->whereYear(
                'expense_date',
                now()->year
            )
            ->sum('amount');

        $expenseCount = Expense::count();

        $categories = Expense::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('expenses.index', compact(
            'expenses',
            'totalExpenses',
            'todayExpenses',
            'monthExpenses',
            'expenseCount',
            'categories'
        ));
    }

    public function create()
    {
        $categories = [
            'Rent',
            'Electricity',
            'Water',
            'Internet',
            'Transport',
            'Salaries',
            'Maintenance',
            'Office Supplies',
            'Marketing',
            'Security',
            'Bank Charges',
            'Other',
        ];

        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'expense_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank,mobile_money',
            ],

            'reference_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'paid_to' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request
                ->file('attachment')
                ->store('expenses', 'public');
        }

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load('user');

        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $categories = [
            'Rent',
            'Electricity',
            'Water',
            'Internet',
            'Transport',
            'Salaries',
            'Maintenance',
            'Office Supplies',
            'Marketing',
            'Security',
            'Bank Charges',
            'Other',
        ];

        return view('expenses.edit', compact(
            'expense',
            'categories'
        ));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'expense_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank,mobile_money',
            ],

            'reference_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'paid_to' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ]);

        if ($request->hasFile('attachment')) {

            if (
                $expense->attachment &&
                Storage::disk('public')->exists($expense->attachment)
            ) {
                Storage::disk('public')
                    ->delete($expense->attachment);
            }

            $validated['attachment'] = $request
                ->file('attachment')
                ->store('expenses', 'public');
        }

        $expense->update($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        if (
            $expense->attachment &&
            Storage::disk('public')->exists($expense->attachment)
        ) {
            Storage::disk('public')
                ->delete($expense->attachment);
        }

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
