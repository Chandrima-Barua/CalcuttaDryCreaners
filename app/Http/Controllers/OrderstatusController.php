<?php

namespace App\Http\Controllers;

use App\Orderstatus;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderstatusController extends Controller
{
    public function index()
    {
        $orderstatuses = Orderstatus::all();

        return view('orderstatus.index')->with('orderstatuses', $orderstatuses);
    }

    public function create()
    {
        return view('orderstatus.create');
    }

    public function store(Request $request)
    {
        $status = Orderstatus::all();
        $orderstatuses = Orderstatus::where('slug', '=', Str::slug($request->input('title'), '-'))->first();
        if ($orderstatuses === null) {
            $request->validate([
            'title' => 'required',
        ]);
            $orderstatuses = new Orderstatus();
            $orderstatuses->title = $request->input('title');
            $orderstatuses->slug = Str::slug($request->input('title'), '-');
            if (count($status) == 0) {
                $orderstatuses->isDefault = true;
            }

            $orderstatuses->save();

            return redirect('/orderstatuses')->with('success', 'Order Status added successfully!');
        } else {
            return redirect('/orderstatuses')->with('error', 'Order Status already exists!');
        }
    }

    public function edit($id)
    {
        $existingOrderstatus = Orderstatus::where('id', $id)->find(1);
        $validator = Validator::make([], []);
        if (!$existingOrderstatus) {
            $validator->errors()->add('not_found', 'Order Status does not exists!');
        }

        return view('orderstatus.edit')->with('orderstatus', $existingOrderstatus);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:30',
         ]);
        if ($validator->fails()) {
            return redirect(route('orderstatus.edit', $id))->withErrors($validator)->withInput();
        }
        $existingOrderstatus = Orderstatus::where('id', $id)->find(1);
        if (!$existingOrderstatus) {
            $validator->errors()->add('not_found', 'Order Status does not exists!');

            return redirect(route('orderstatus.edit', $id))->withErrors($validator)->withInput();
        }
        $existingOrderstatus->title = $request->input('title');
        $existingOrderstatus->slug = Str::slug($existingOrderstatus->title, '-');
        try {
            $existingOrderstatus->save();

            return redirect(route('orderstatus.index'))->with('successes', ['Order Status successfully updated!']);
        } catch (QueryException $e) {
            $validator->errors()->add('database_issue', 'Order Status could not be saved due to database issue!');

            return redirect(route('orderstatus.edit', $id))->withErrors($validator)->withInput();
        }
    }

    public function makedefault($id)
    {
        $validator = Validator::make([], []);
        $orderstatus = Orderstatus::findOrFail($id);
        if (!$orderstatus) {
            $validator->errors()->add('not_found', 'Order Status you are trying to delete does not exist!');

            return redirect(route('orderstatus.index'))->withErrors($validator);
        }
        $orderstatuses = Orderstatus::all();
        foreach ($orderstatuses as $orderStatus) {
            $orderStatus->isDefault = false;
            $orderStatus->save();
        }
        $orderstatus->isDefault = true;
        $orderstatus->save();

        return redirect(route('orderstatus.index'))->with('successes', ["$orderstatus->title made default!"]);
    }

    public function destroy($id)
    {
        $validator = Validator::make([], []);
        $orderstatus = Orderstatus::where('id', $id)->find(1);
        if (!$orderstatus) {
            $validator->errors()->add('not_found', 'Order Status you are trying to delete does not exist!');

            return redirect(route('.orderstatus.index'))->withErrors($validator);
        }
        try {
            $orderstatus->delete();

            return redirect(route('orderstatus.index'))->with('successes', ['Order Status successfully deleted!']);
        } catch (QueryException $e) {
            $validator->errors()->add('database_issue', 'Could not delete Order Status due to database error!');

            return redirect(route('orderstatus.index'))->withErrors($validator);
        }
    }
}
