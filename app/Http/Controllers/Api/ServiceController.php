<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\Item;
class ServiceController extends Controller
{
   
    public function index(Request $request)
    {
        $services = Service::all();
        return response()->json(['data' =>  $services]);

    }

  
    public function show(Request $request)
    {
        $serviceid = $request->input('service_id');
        $service = Service::find($serviceid);
        return response()->json(['data' =>  $service]);
    }

   
    public function getallservice(Request $request)
     {

        $code = $request->input('code');
        $item = Item::where('code',$code)->groupby('code')
        ->get();

        $services = Item::where('items.code', $code)->join('services', 'services.id', '=', 'items.service_id')
        ->select('services.*', 'services.id as service_id', 'services.name as service_name')
        ->get();

         return response()->json( [ 'services' => $services]);
        
     }
}
