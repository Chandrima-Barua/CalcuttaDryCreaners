<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Item;
use App\Service;
use App\ItemType;
use Validator;
class ItemController extends Controller
{
   
    public function index(Request $request)
    {
        
   
        $items = Item::select('items.*','items.name as item_name', 'services.name as service_name')->join('services', 'services.id', '=', 'items.service_id')->get();

        if($request->wantsJson()){
            
            return response()->json(['data' => $items]);

        }else{
            return view('items.index')->with(['items'=> $items]);
        }
    }



    public function create()
    {
        $services = Service::all();
        $itemstypes = ItemType::all();
        return view('items.create')->with(['services'=> $services, 'itemstypes'=> $itemstypes]);
    }



    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'code' => 'required|max:30',
            'services.*' => 'required',
            'discount' => 'boolean',
            'regularPrice.*' => 'required',
            'urgentPrice.*' => 'required',
            'regularDeliveryTime.*' => 'required',
            'urgentDeliveryTime.*' => 'required',
        ]);
        
        
        $name = $_POST['name'];

        $regularPrice = array_values(array_filter($_POST['regularPrice']));
        $urgentPrice =  array_values(array_filter($_POST['urgentPrice']));
        $regularDeliveryTime =  array_values(array_filter($_POST['regularDeliveryTime']));
        $urgentDeliveryTime =  array_values(array_filter($_POST['urgentDeliveryTime']));

        $services =  $_POST['services'];

        $item = Item::where('slug', '=', Str::slug($request->input('name'), '-'))->first();
        if ($item === null) {
        for($i=0; $i<count($services) ; $i++){

        $item = new Item();
        $item->name = $request->input('name');
        $item->service_id = $services[$i];
        $item->code = $request->input('code');
        $item->slug = Str::slug($request->input('name'), '-');
        $item->itemTypeid  = $request->input('itemTypeid');
        $item->discount = $_POST['discount'][$i];
        $item->regularPrice = $regularPrice[$i];
        $item->urgentPrice =$urgentPrice[$i];
        $item->regularDeliveryTime = $regularDeliveryTime[$i];
        $item->urgentDeliveryTime = $urgentDeliveryTime[$i];
        $item->itemNote = $request->input('itemNote');
        $item->save();
        
        }

        return redirect(route('items.index'))->with('successes', ['New Item Created!']);
    }

    else{
        // $validator->errors()->add('already_exists', 'Order Status already exists!');
        // return redirect(route('orderstatus.create'))->withErrors($validator)->withInput();
        return redirect(route('items.index'))->with('successes', ['Item already exists!']);
    }
        
}

   
    public function show(Request $request, $id)
    {

        $item = Item::findOrFail($id);
        $services = Service::all();
        $itemstypes = ItemType::all();
        
        if($request->wantsJson()){
            
            return response()->json(['item' => $item]);

        }
        else{

        return view('items.show')->with(['item' => $item, 'services'=>$services,'itemstypes'=> $itemstypes]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $item = Item::findOrFail($id);
        $services = Service::all();
        $itemstypes = ItemType::all();
        return view('items.edit')->with(['item' => $item, 'services'=>$services,'itemstypes'=> $itemstypes]);    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'code' => 'required|max:30',
            'services.*' => 'required',
            // 'itemTypeid' => 'integer',
            // 'tax' => 'required',
            'discount' => 'boolean',
            // 'discountType' => 'required',
            'regularPrice.*' => 'required',
            'urgentPrice.*' => 'required',
            'regularDeliveryTime.*' => 'required',
            'urgentDeliveryTime.*' => 'required',
        ]);
        
        
        
        $name = $_POST['name'];

        $regularPrice = array_values(array_filter($_POST['regularPrice']));
        $urgentPrice =  array_values(array_filter($_POST['urgentPrice']));
        $regularDeliveryTime =  array_values(array_filter($_POST['regularDeliveryTime']));
        $urgentDeliveryTime =  array_values(array_filter($_POST['urgentDeliveryTime']));
        
        
        $services =  $_POST['services'];
        
        
        for($i=0; $i<count($services) ; $i++){
            
            $item = Item::find($id);
            $item->name = $request->input('name');
            $item->service_id = $services[$i];
            $item->code = $request->input('code');
            $item->slug = Str::slug($request->input('name'), '-');
            $item->itemTypeid  = $request->input('itemTypeid');
            // $item->type  = $request->input('id');
            // $item->tax =$request->input('tax');
            // $item->discount =$request->input('discount');
            $item->discount = $_POST['discount'][$i];
            // $item->discountType = $request->input('discountType');
            $item->regularPrice = $regularPrice[$i];
            $item->urgentPrice =$urgentPrice[$i];
            $item->regularDeliveryTime = $regularDeliveryTime[$i];
            $item->urgentDeliveryTime = $urgentDeliveryTime[$i];
            $item->itemNote = $request->input('itemNote');
                $item->save();
        }
        // $services = $request->input('services');  
        // $item->services()->sync($services);
       

        if($request->wantsJson()){
            
            return response()->json([
                "message" => "items updated successfully",
               
            ], 200);

        }else{

        return redirect(route('items.show', $id))->with('successes', ['Successfully edited!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = Item::find($id);
        $item->delete();
       
        if($request->wantsJson()){
            
            return response()->json([
                "message" => "item deleted successfully"
            ], 200);

        }
        else{

        return redirect('/items')->with('success', 'Item deleted!');
        }
    }
}