<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseCategory;
use Illuminate\Support\Str;

class ExpenseCategoriesController extends Controller
{
    public function index()
    {
        $expense_categories = ExpenseCategory::all();

        return view('expense_categories.index', compact('expense_categories'));
    }

    public function create()
    {
        return view('expense_categories.create');
    }

    public function store(Request $request)
    {
        $expense_category = ExpenseCategory::where('slug', '=', Str::slug($request->input('name'), '-'))->first();
        if ($expense_category === null) {
            $request->validate([
            'name' => 'required',
        ]);
            $expense_category = new ExpenseCategory();
            $expense_category->name = $request->input('name');
            $expense_category->slug = Str::slug($request->input('name'), '-');
            $expense_category->save();

            return redirect('/expense_categories')->with('success', 'Category created!');
        } else {
            return redirect('/expense_categories')->with('error', 'Category already exists!');
        }
    }

    
    public function edit($id)
    {
        $expense_category = ExpenseCategory::find($id);

        return view('expense_categories.edit', compact('expense_category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $expense_category = ExpenseCategory::find($id);
        $expense_category->name = $request->get('name');
        $expense_category->slug = Str::slug($request->get('name'), '-');
        $expense_category->save();

        return redirect('/expense_categories')->with('success', 'Category updated!');
    }

    public function destroy($id)
    {
        $expense_category = ExpenseCategory::find($id);
        $expense_category->delete();

        return redirect('/expense_categories')->with('success', 'Category deleted!');
    }
}
