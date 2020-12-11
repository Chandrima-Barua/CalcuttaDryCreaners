<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::all();

        return view('branch.index', compact('branches'));
    }

    public function create()
    {
        return view('branch.create');
    }

    public function store(Request $request)
    {
        $branch = Branch::where('slug', '=', Str::slug($request->input('name'), '-'))->first();
        if ($branch === null) {
            // user doesn't exist

            $request->validate([
            'name' => 'required',
            'address' => 'required',
            'start_limit' => 'required',
            'end_limit' => 'required',
        ]);
            $branch = new Branch();
            $branch->name = $request->input('name');
            $branch->slug = Str::slug($request->input('name'), '-');
            $branch->address = $request->input('address');
            $branch->start_limit = $request->input('start_limit');
            $branch->running_no = $request->input('running_no');
            $branch->end_limit = $request->input('end_limit');
            $branch->save();

            return redirect('/branches')->with('success', 'branch created!');
        } else {
            return redirect('/branches')->with('error', 'Branch already exists!');
        }
    }

    public function edit($id)
    {
        $branch = Branch::find($id);

        return view('branch.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'start_limit' => 'required',
            'end_limit' => 'required',
        ]);

        $branch = Branch::find($id);
        $branch->name = $request->get('name');
        $branch->slug = Str::slug($request->get('name'), '-');
        $branch->address = $request->input('address');
        $branch->start_limit = $request->input('start_limit');
        $branch->running_no = $request->input('running_no');
        $branch->end_limit = $request->input('end_limit');
        $branch->save();

        return redirect('/branches')->with('success', 'Branch updated!');
    }

    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();

        return redirect('/branches')->with('success', 'Branch deleted!');
    }
}
