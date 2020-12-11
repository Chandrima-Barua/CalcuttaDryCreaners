<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Expense;
use App\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();

        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        $branches = Branch::all();
        $expense_categories = ExpenseCategory::all();

        return view('expense.create', compact('branches', 'expense_categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expense_category_id' => 'required|integer',
            'branch_id' => 'required|integer',
            'entry_date' => 'required|date',
            'amount' => 'required|string',
        ]);

        $expense = new Expense();
        $expense->expense_category_id = $request->input('expense_category');
        $expense->branch_id = $request->input('branch');
        $expense->entry_date = Carbon::parse($request->input('entry_date'));
        $expense->amount = $request->input('amount');
        $expense->save();

        return redirect('/expenses')->with('success', 'Expense created!');
    }

    public function show($id)
    {
        $expense = Expense::find($id);
        $branch = $expense->branch;
        $expense_category = $expense->expense_category;

        return view('expense.show')->with(['expense' => $expense, 'branch' => $branch, 'expense_category' => $expense_category]);
    }

    public function edit($id)
    {
        $expense = Expense::find($id);
        $branches = Branch::all();
        $expense_categories = ExpenseCategory::all();

        return view('expense.edit')->with(['expense' => $expense, 'branches' => $branches, 'expense_categories' => $expense_categories]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'expense_category_id' => 'required|integer',
            'branch_id' => 'required|integer',
            'entry_date' => 'required|date',
            'amount' => 'required|string',
        ]);
        $expense = Expense::find($id);
        $expense_category_id = $request->input('expense_category');
        $branch_id = $request->input('branch');
        $expense->entry_date = Carbon::parse($request->input('entry_date'));
        $expense->amount = $request->input('amount');

        $branch = Branch::find($branch_id);
        $expense_category = ExpenseCategory::find($expense_category_id);
        $branch->expenses()->save($expense);
        $expense_category->expenses()->save($expense);

        return view('expense.show')->with(['expense' => $expense, 'branch' => $branch, 'expense_category' => $expense_category]);
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        return redirect('/expense')->with('success', 'Expense deleted!');
    }
    
}
