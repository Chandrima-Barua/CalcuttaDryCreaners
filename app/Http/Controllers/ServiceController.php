<?php
// use Illuminate\Support\Facades\Auth; 
namespace App\Http\Controllers\Api;

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Service;
use App\Item;
use Validator;

class ServiceController extends Controller
{
    

    public function index(Request $request)
    {
        $services = Service::all();
       
        if($request->wantsJson()){
            
            return response()->json(['data' =>  $services]);

        }else{
            return view('services.index', compact('services'));
        }

        
    }

   
    public function create()
    {
        return view('services.create');
    }

    
    public function store(Request $request)
    {
        
        $service = Service::where('slug', '=', Str::slug($request->input('name'), '-'))->first();

        if ($service === null) {
        $request->validate([
            'name'=>'required',
            
        ]);
        $service = new Service();
        $service->name = $request->input('name');
        $service->slug = Str::slug($request->input('name'), '-');
        $service->save();

        if($request->wantsJson()){
            
            return response()->json([
                "message" => "Service record created"
            ]);

        }else{

            return redirect('/services')->with('success', 'Service created!');
        }
    }
    else{
        return redirect('/services')->with('error', 'Service already exists!');
    }
       
    }

    
    public function edit(Request $request , $id)
    {
        $service = Service::find($id);

        if($request->wantsJson()){
            
            return response()->json(['data' =>  $service]);

        }else{
            return view('services.edit', compact('service'));
        }
    }

   
    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=>'required',
            
        ]);

        $service = Service::find($id);
        $service->name =  $request->get('name');
        $service->save();


        if($request->wantsJson()){
            
            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else{
            return redirect('/services')->with('success', 'Service updated!');
        }

       
    }


    public function destroy(Request $request,$id)
    {
        $service = Service::find($id);
        $service->delete();
        if($request->wantsJson()){
            
            return response()->json([
                "message" => "records Deleted successfully"
            ], 200);
            } 
            else{
        return redirect('/services')->with('success', 'Service deleted!');
    }
}
}