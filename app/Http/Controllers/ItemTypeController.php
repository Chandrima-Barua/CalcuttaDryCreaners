<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\ItemType;

class ItemTypeController extends Controller
{
    
    public function index(Request $request)
    {
        $itemtypes = ItemType::all();
       
        if($request->wantsJson()){
            
            return response()->json(['itemtypes' =>  $itemtypes]);

        }else{
            return view('itemtype.index', compact('itemtypes'));
        }
    }

   
    public function create()
    {
        return view('itemtype.create');
    }

    
    public function store(Request $request)
    {
        $itemtype = ItemType::where('slug', '=', Str::slug($request->input('name'), '-'))->first();

        if ($itemtype === null) {
        $request->validate([
            'name'=>'required',
            
        ]);
        $itemtype = new ItemType();
        $itemtype->name = $request->input('name');
        $itemtype->slug = Str::slug($request->input('name'), '-');
        $itemtype->save();

        if($request->wantsJson()){
            
            return response()->json([
                "message" => "New Item Type  created"
            ]);

        }else{

            return redirect('/itemtype')->with('success', 'New Item Type created!');
        }
    }
    else{
        return redirect('/itemtype')->with('error', 'Item Type already exists!');
    }
}

  
    public function show($id)
    {
        //
    }

   
    public function edit(Request $request , $id)
    {
        $itemtype = ItemType::find($id);

        if($request->wantsJson()){
            
            return response()->json(['itemtype' =>  $itemtype]);

        }else{
            return view('itemtype.edit', compact('itemtype'));
        }
    }

  
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            
        ]);

        $itemtype = ItemType::find($id);
        $itemtype->name =  $request->get('name');
        $itemtype->save();


        if($request->wantsJson()){
            
            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else{
            return redirect('/itemtype')->with('success', 'itemtype updated!');
        }
    }

   
    public function destroy(Request $request,$id)
    {
        $itemtype = ItemType::find($id);
        $itemtype->delete();
        if($request->wantsJson()){
            
            return response()->json([
                "message" => "records Deleted successfully"
            ], 200);
            } 
            else{
        return redirect('/itemtype')->with('success', 'ItemType deleted!');
    }
    }
}
