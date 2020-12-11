<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Item;
use App\Service;
use App\ItemType;
use App\User;  


class ClothsController extends Controller
{
    
    public function index(Request $request)
    {
        
        $items = Item::select('items.id as itemId','items.id as itemId','items.name as itemName','items.regularPrice as regularPrice','items.urgentPrice as urgentPrice','item_types.name as modelName', 'services.name as serviceType')
        ->join('services', 'services.id', '=', 'items.service_id')
        ->join('item_types', 'item_types.id', '=', 'items.itemTypeid')
        ->get();

       
        return response()->json(['data' => $items]);

        
    }

  
}
