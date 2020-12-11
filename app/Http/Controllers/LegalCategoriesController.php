<?php

namespace App\Http\Controllers;

use App\LegalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegalCategoriesController extends Controller
{
    public function index()
    {
        $legal_categories = LegalCategory::all();

        return view('legal_categories.index', compact('legal_categories'));
    }

    public function create()
    {
        return view('legal_categories.create');
    }

    public function store(Request $request)
    {
        $legal_category = LegalCategory::where('slug', '=', Str::slug($request->input('name'), '-'))->first();
        if ($legal_category === null) {
            $request->validate([
            'name' => 'required',
        ]);
            $legal_category = new LegalCategory();
            $legal_category->name = $request->input('name');
            $legal_category->slug = Str::slug($request->input('name'), '-');
            $legal_category->save();

            return redirect('/legal_categories')->with('success', 'Legal Category created!');
        } else {
            return redirect('/legal_categories')->with('error', 'Legal Category already exists!');
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $legal_category = LegalCategory::find($id);

        return view('legal_categories.edit', compact('legal_category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $legal_category = LegalCategory::find($id);
        $legal_category->name = $request->get('name');
        $legal_category->slug = Str::slug($request->get('name'), '-');
        $legal_category->save();

        return redirect('/legal_categories')->with('success', 'Legal Category updated!');
    }

    public function destroy($id)
    {
        $legal_category = LegalCategory::find($id);
        $legal_category->delete();

        return redirect('/legal_categories')->with('success', 'Legal Category deleted!');
    }
}
