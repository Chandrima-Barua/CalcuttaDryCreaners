<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Item;
use App\Notifications\MyNotification;
use App\Order;
use App\OrderItem;
use App\Orderstatus;
use App\Service;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // $orders = Order::all();
        $orders = Order::orderBy('created_at', 'desc')->get();
        $orderstatus = Orderstatus::all();

        if ($request->wantsJson()) {
            return response()->json(['orders' => $orders, 'orderstatus' => $orderstatus]);
        } else {
            return view('orders.index')->with(['orders' => $orders, 'orderstatus' => $orderstatus]);
        }
    }

    public function create()
    {
        $word = 'corporate';
        $mystring = \Request::url();

        // Test if string contains the word

        $itemname = Item::groupBy('slug')->get();
        $today = Carbon::today();
        $customers = User::all();
        $branches = Branch::all();

        $itemloop = Item::groupBy('service_id')->get();

        if (strpos($mystring, $word) !== false) {
            return view('orders.create_corporate')->with(['itemloop' => $itemloop, 'itemname' => $itemname, 'branches' => $branches]);
        } else {
            return view('orders.create')->with(['itemloop' => $itemloop, 'itemname' => $itemname, 'branches' => $branches]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customername' => 'required|string',
            'customer_address' => 'required|string',
            'user_id' => 'required|integer',
            'phone_number' => 'string',
            'branchname' => 'required',
            'qty' => 'required|integer',
            'tax' => 'string',
            'discountvalue' => 'required|string',
            'subtotal' => 'required',
            'total' => 'required',
            // 'advance_payment' => 'double',
            // 'due_payment' => 'double',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect((route('orders.create')))->withErrors($validator)->withInput();
        }
        try {
            $order = new Order();
            $order->customername = $request->input('customername');
            $order->customer_address = $request->input('customer_address');
            $order->phone_number = $request->input('phone_number');
            $order->branch_id = $request->input('branchname');
            $order->order_id = $request->input('order_id');
            $order->user_id = $request->input('user_id');
            $order->qty = $request->input('qty');
            $order->tax = $request->input('tax');
            $order->discountvalue = $request->input('discountvalue');
            $order->subtotal = $request->input('subtotal');
            $order->total = $request->input('total');
            $order->advance_payment = $request->input('advance_payment');
            $order->due_payment = $request->input('due_payment');
            $order->due_date = Carbon::parse($request->input('due_date'));

            $orderstatus = Orderstatus::where('isDefault', 1)->first();
            $orderstatus->orders()->save($order);

            $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',

            'quantity' => 'required|integer',
            'price' => 'required|double',
            'urgent' => 'required|boolean',
            'regular' => 'required|boolean',
            'status' => 'string',
            'packaging' => 'string',
            'date' => 'date',
        ]);
            // dd($_POST['servicecharge']);
            $unitprices = explode(',', $_POST['price']);
            $unitqty = explode(',', $_POST['quantity']);
            $allservices = array_values(array_filter($_POST['orderitem']));
            $items = explode(',', $_POST['item_id']);
            $urgent = explode(',', $_POST['urgent']);
            $regular = explode(',', $_POST['regular']);

            $order_id = $order->id;

            for ($i = 0; $i < count($allservices); ++$i) {
                $orderitem = new OrderItem();
                $orderitem->order_id = $order->id;

                $orderitem->service_id = $allservices[$i];
                $orderitem->item_id = $items[$i];
                $orderitem->quantity = $unitqty[$i];
                $orderitem->price = $unitprices[$i];
                $orderitem->urgent = $urgent[$i];
                $orderitem->regular = $regular[$i];
                $orderitem->status = $_POST['status'][$i];
                $orderitem->packaging = $_POST['packaging'][$i];
                $orderitem->service_charge = $_POST['servicecharge'][$i];
                $orderitem->date = Carbon::parse($request->input('created_at'));
                $orderitem->save();
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'order created successfully',
                ], 200);
            } else {
                return redirect(route('orders.index'))->with('successes', ['New Order Created!']);
            }
        } catch (InternalErrorException $e) {
            $validator->errors()->add('could_not_save', 'Could not create new Order!');

            return redirect((route('orders.create')))->withErrors($validator)->withInput();
        }
    }

    public function show(Request $request, $id)
    {
        $today = Carbon::today();
        $order = Order::find($id);
        $branch = $order->branch;
        $orderitems = OrderItem::where('order_id', $id)->join('services', 'services.id', '=', 'order_items.service_id')
            ->join('items', 'items.id', '=', 'order_items.item_id')
            ->select('order_items.*', 'items.id as item_id', 'items.name as item_name', 'items.slug as item_slug', 'items.regularDeliveryTime as regulartime', 'items.urgentDeliveryTime as urgenttime', 'services.name as service_name')
            ->get();

        if ($request->wantsJson()) {
            return response()->json(['order' => $order]);
        } else {
            return view('orders.show')
            ->with(['today' => $today, 'order' => $order, 'orderitems' => $orderitems, 'branch' => $branch]);
        }
    }

    public function edit($id)
    {
        $itemname = Item::groupBy('slug')->get();
        $today = Carbon::today();
        $customers = User::all();
        $order = Order::find($id);

        $orderitems = OrderItem::where('order_id', $id)->join('services', 'services.id', '=', 'order_items.service_id')
            ->join('items', 'items.id', '=', 'order_items.item_id')
            ->select('order_items.*', 'items.name as item_name', 'items.slug as item_slug', 'services.name as service_name')
            ->get();

        return view('orders.edit')->with(['itemname' => $itemname, 'order' => $order, 'orderitems' => $orderitems]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customername' => 'required|string',
            'customer_address' => 'required|string',
            'phone_number' => 'string',
            'qty' => 'required|integer',
            'tax' => 'required|string',
            'discountvalue' => 'required|string',
            'subtotal' => 'required|integer',
            'total' => 'required|integer',
            'due_date' => 'required|date',
        ]);

        $order = Order::find($id);
        $order->customername = $request->input('customername');
        $order->customer_address = $request->input('customer_address');
        $order->phone_number = $request->input('phone_number');
        $order->qty = $request->input('qty');
        $order->tax = $request->input('tax');
        $order->discountvalue = $request->input('discountvalue');
        $order->subtotal = $request->input('subtotal');
        $order->total = $request->input('total');
        $order->due_date = Carbon::parse($request->input('due_date'));
        $order->save();

        //update order_items table
        // $validator = Validator::make($request->all() , array(
        //     'order_id' => 'required|integer',
        //     'services.*' => 'required',
        //     'items.*' => 'required',
        //     'quantity' => 'required|integer',
        //     'price' => 'required|double',
        //     'unitprice*.' => 'required|double',
        //     'unitqty*.' => 'required|integer',
        //     'discount' => 'required|boolean',
        //     'discountType' => 'required|string',
        //     'discountvalue' => 'required|double',

        // ));

        // $unitprices = explode(",", $_POST['unitprice']);

        // $unitqty = explode(",", $_POST['unitqty']);

        // $serviceIds = explode(",", $_POST["allservices"]);

        // // $serviceIds = $request->input('services');
        // $deleteIds = array_unique(explode(",", $_POST['deleteitemid']));
        // $deleteserviceIds = array_unique(explode(",", $_POST['deleteserviceid']));

        // foreach ($serviceIds as $serviceId)
        // {
        //     $services = Service::find($serviceId);

        // }

        // $itemIds = explode(",", $_POST['items']);
        // // dd($itemIds);
        // foreach ($itemIds as $itemId)
        // {
        //     $items = Item::find($itemId);

        // }

        // dd( $itemIds);
        //check the services exist in database
        //     $order_id = $order->id;
        //     $oldservices = OrderItem::where('order_id', $id)->select('service_id')
        //         ->get()
        //         ->toArray();

        //     $oldservicearray = array();

        //     for ($i = 0;$i < count($oldservices);$i++)
        //     {

        //         $oldservicearray[] = $oldservices[$i]['service_id'];

        //     }
        //     //

        //     //check the items exist in database

        //     $olditems = OrderItem::where('order_id', $id)->select('item_id')->get()->toArray();
        //     $olditemarray = array();
        //     for ($i = 0;$i < count($olditems);$i++)
        //     {

        //         $olditemarray[] = $olditems[$i]['item_id'];

        //     }

        //     //checking the stored values with new values
        //     $serviceresult = empty(array_intersect($serviceIds, $oldservicearray));
        //     $itemresult = empty(array_intersect($itemIds, $olditemarray));

        //     if(count($deleteIds) > 0){
        //         $deleteitem = array_intersect($deleteIds, $itemIds);
        //     }

        //     $diffservice = array_diff($serviceIds, $oldservicearray);
        //     $diffitem = array_diff($itemIds, $olditemarray);
        // //     print_r($deleteIds);
        // //    dd($deleteitem);
        //     $diff = [];
        //     $larger_array = $olditemarray;
        //     $smaller_array = $itemIds;

        //     if(count($itemIds) > count($olditemarray))
        //     {
        //         $larger_array = $itemIds;
        //         $smaller_array = $olditemarray;
        //     }

        //     foreach($larger_array as $ele)
        //     {
        //         if(!in_array($ele,$smaller_array))
        //         {
        //             $diff[] = $ele;
        //         }
        //     }

        //     // dd($diff) ;

        //     //for new service new orderitems will be inserted
        //     if (count($diffservice) > 1){

        //         $limit = count($diffservice);

        //         for ($j = 0; $j < $limit; $j++)
        //             {

        //                 $orderitem = new OrderItem();
        //                 $orderitem->order_id = $id;

        //                     foreach ($serviceIds as $serviceId)
        //                     {
        //                         $orderitem->service_id = $serviceId;

        //                     }

        //                     foreach ($diffitem as $itemId)
        //                     {

        //                         $orderitem->item_id = $itemId;

        //                     }
        //                     foreach ($unitqty as $qty)
        //                     {

        //                 $orderitem->quantity = $qty;
        //                     }

        //                 $orderitem->price = $unitprices[$j];

        //                 $orderitem->discount = $request->input('discount');
        //                 $orderitem->discountType = $request->input('discountType');
        //                 $orderitem->discountvalue = $request->input('discountvalue');
        //                 $orderitem->save();

        //             }
        //             $orderitems = OrderItem::find($orderitem->id);
        //             foreach ($diffservice as $services)
        //                 {
        //                     $services->orderitems()
        //                         ->save($orderitems);
        //                 }
        //                 foreach ($diffitem as $items)
        //                 {
        //                     // $items = Item::find($itemId);
        //                     $items->orderitems()
        //                         ->save($orderitems);
        //                 }
        //     }

        //     //for new items new orderitems will be inserted
        //     else if (count($diffitem) > 0){

        //         $limit = count($diffitem);
        //         for ($j = 0; $j < $limit; $j++)
        //             {
        //                 $orderitem = new OrderItem();
        //                  $orderitem->order_id = $order->id;
        //                 foreach ($serviceIds as $serviceId)
        //                 {
        //                     $orderitem->service_id = $serviceId;

        //                 }
        //                 foreach ($itemIds as $itemId)
        //                 {
        //                     $orderitem->item_id = $itemId;
        //                 }
        //                 foreach ($unitqty as $qty)
        //                     {

        //                 $orderitem->quantity = $qty;
        //                     }
        //                     foreach ($unitprices as $unitprice)
        //                     {
        //                 $orderitem->price = $unitprice;
        //                     }
        //                 $orderitem->discount = $request->input('discount');
        //                 $orderitem->discountType = $request->input('discountType');
        //                 $orderitem->discountvalue = $request->input('discountvalue');
        //                 $orderitem->save();

        //             }

        //             $orderitems = OrderItem::find($orderitem->id);
        //                 foreach ($diffservice as $serviceId)
        //                 {
        //                     $services = Service::find($serviceId);
        //                     $services->orderitems()
        //                         ->save($orderitems);
        //                 }
        //                 foreach ($diffitem as $itemId)
        //                 {
        //                     $items = Item::find($itemId);
        //                     $items->orderitems()
        //                         ->save($orderitems);
        //                 }

        //     }

        //     //for updating orderitems
        //     if((count($diffitem) == 0) || (( count($deleteitem) > 0) && ( count($deleteIds) > 0))){

        //         $limit = count($itemIds);
        //         $orderitem = OrderItem::where('order_id', $id)->get();
        //         for ($j = 0; $j < $limit; $j++)
        //             {
        //                 $orderitem[$j]->order_id = $order->id;
        //                 $orderitem[$j]->service_id = $serviceIds[$j];
        //                 $orderitem[$j]->item_id = $itemIds[$j];
        //                 $orderitem[$j]->quantity = $unitqty[$j];
        //                 $orderitem[$j]->price = $unitprices[$j];
        //                 $orderitem[$j]->discount = $request->input('discount');
        //                 $orderitem[$j]->discountType = $request->input('discountType');
        //                 $orderitem[$j]->discountvalue = $request->input('discountvalue');
        //                 $orderitem[$j]->save();

        //                 // $orderitems = OrderItem::find($orderitem[$j]->id);

        //             }
        //     }

        //      if((count($itemIds) < count($olditemarray)) && ( count($deleteitem) == 0)){

        //         for($k=0; $k <count($deleteIds) ; $k++){

        //         $orderitem = OrderItem::where('item_id', $deleteIds[$k]);
        //         $orderitem->delete();

        //         }
        //         // foreach ($deleteserviceIds as $deleteserviceId)
        //         // {
        //         //     $services = Service::find($deleteserviceId);
        //         //     $services->orderitems()->detach();

        //         // }
        //         foreach ($deleteIds as $deleteId)
        //         {
        //             $items = Item::find($deleteId);
        //             $items->orderitems()->detach();

        //     }

        // }

        if ($request->wantsJson()) {
            return response()->json([
                    'message' => 'order updated successfully',
                ], 200);
        } else {
            return redirect(route('orders.index', $id))->with('successes', ['Successfully Updated your Order!']);
        }
    }

    public function destroy(Request $request, $id)
    {
        $order = Order::find($id);
        $order->delete();
        $orderitem = OrderItem::where('order_id', $id);
        $orderitem->delete();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'order deleted successfully',
            ], 200);
        } else {
            return redirect('/orders')
            ->with('success', 'Order deleted!');
        }
    }

    // Fetch records for items of each services
    public function getItems($serviceId, $slug)
    {
        $items = Item::where('service_id', $serviceId)->where('slug', $slug)->get();
        $today = Carbon::today();

        return response()->json($items);
    }

    public function getCarts($order_id)
    {
        $cart = OrderItem::where('order_id', $order_id)->get()->toArray();

        return response()->json($cart);
    }

    // Fetch records for items of each services
    public function getServices($slug)
    {
        $item = Item::where('slug', $slug)->groupby('slug')
        ->get();

        $services = Item::where('items.slug', $slug)->join('services', 'services.id', '=', 'items.service_id')
        ->select('services.*', 'services.id as service_id', 'services.name as service_name')
        ->get();

        return response()->json(['services' => $services, 'item' => $item]);
    }

    public function searchitems(Request $request, $code)
    {
        $data = Item::where('code', 'LIKE', $code.'%')->groupby('slug')
                ->get();

        $output = '';

        if (count($data) > 0) {
            $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';

            foreach ($data as $row) {
                $output .= '<li class="list-group-item itemlist" id="'.$row->slug.'">'.$row->name.'</li>';
            }

            $output .= '</ul>';
        } else {
            $output .= '<li class="list-group-item">'.'No results'.'</li>';
        }

        return $output;
    }

    public function updatestatus(Request $request, $id)
    {
        $apiKey = 'U2hlaWtoOlNoZWlraFJhODky';

        $order = Order::find($id);
        $order->orderstatus_id = $request->orderstatusid;
        $order->save();
        $status = Orderstatus::find($request->orderstatusid);
        if ($status['slug'] == 'ready-in-shop') {
            $url = 'https://smspanellogin.com/api/bulkSmsApi';

            $smsdata = [
         'sender_id' => '52',
         'apiKey' => $apiKey,
         'mobileNo' => $order->phone_number,
         'message' => 'Order no.'.' '.$order->id.' '.'is '.' '.$status['title'],
         ];

            $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'key='.$apiKey,
            ],
        ]);

            $response = $client->post('https://smspanellogin.com/api/bulkSmsApi',
            ['body' => json_encode($smsdata)]
        );
            echo $response->getBody();
            // print_r($smsdata);

            // $headers = [];
            // $headers[] = 'Content-type: application/json';
            // $headers[] = 'Connection: Keep-Alive';
            // $curl = \curl_init($url);
            // $curl = curl_init($url);

            // curl_setopt($curl, CURLOPT_POSTFIELDS, $smsdata);
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            // curl_setopt($curl, CURLOPT_VERBOSE, true);
            // curl_exec($curl);
            // print_r(curl_getinfo($curl));

        // curl_close($curl);
        }

        // return response()->json(['order' => $order]);
    }

    public function orderstatusPush(Request $request)
    {
        // define('API_ACCESS_KEY', 'AAAAnjo7zAA:APA91bFpnQ8LLDFAN2E0yKSd3gXtgbktxXo-Wd2qcMDGht7WO8BJLWdmW_FxqzgzMjlzthJ0wO1wr5Pn-jfiPHSCPw2JDXKIsaa3JcgSWCzvuknG5IqKUqWkO81hR4OapyixbK7VLXVq');
        $access_token = 'AAAAnjo7zAA:APA91bFpnQ8LLDFAN2E0yKSd3gXtgbktxXo-Wd2qcMDGht7WO8BJLWdmW_FxqzgzMjlzthJ0wO1wr5Pn-jfiPHSCPw2JDXKIsaa3JcgSWCzvuknG5IqKUqWkO81hR4OapyixbK7VLXVq';
        $user = User::find($request->user_id);

        $status = Orderstatus::find($request->orderstatusid);

        $data = [
            'to' => $user->deviceId,
            'notification' => [
                'title' => 'Order Status has been changed',
                'body' => Auth::user()->roles[0]['name'].' '.'has changed the status of the order no.'.' '.$request->orderid.'  '.'to'.' '.$status->title,
                ],
        ];

        $client = new \GuzzleHttp\Client([
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'key='.$access_token,
                        ],
                    ]);

        $response = $client->post('https://fcm.googleapis.com/fcm/send',
                        ['body' => json_encode($data)]
                    );

        echo $response->getBody();
        // echo $user->deviceId;
        // return response()->json(['response' => $response->getBody()]);
        // $ch = \curl_init();
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        // curl_exec($ch);

        $offerData = [
            'firstname' => $user->firstname,
            'role' => Auth::user()->roles[0]['name'],
            'order_id' => $request->orderid,
            'orderstatus' => $status->title,
            'body' => 'Order status has been changed.',
            'thanks' => 'Thank you',
            'user_id' => $user->id,
        ];
        $user->notify(new MyNotification($offerData));
    }

    public function getbranch(Request $request, $id)
    {
        $branch = Branch::find($id);
        $lastorderno = Order::where('branch_id', $id)->select('order_id')->latest('created_at')->first();

        return response()->json(['branch' => $branch, 'lastorderno' => $lastorderno]);
    }
}
