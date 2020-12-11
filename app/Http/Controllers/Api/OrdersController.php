<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use App\Orderstatus;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends Controller
{
    public function orderlist(Request $request)
    {
        $userid = $request->input('user_id');

        $orders = Order::where('user_id', $userid)->select('orders.*', 'orderstatuses.id as status_id', 'orderstatuses.title as orderStatus')
        ->join('orderstatuses', 'orderstatuses.id', '=', 'orders.orderstatus_id')->orderby('orders.orderstatus_id', 'asc')
        ->get();

        return response()->json(['orders' => $orders]);
    }

    public function activeorders(Request $request)
    {
        $userid = $request->input('user_id');

        $orders = Order::where('user_id', $userid)->select('orders.*', 'orderstatuses.id as status_id', 'orderstatuses.title as orderStatus')
        ->join('orderstatuses', 'orderstatuses.id', '=', 'orders.orderstatus_id')->where('orders.orderstatus_id', 1)
        ->get();

        return response()->json(['active_orders' => $orders]);
    }

    public function store(Request $request)
    {
        $orderdata = $request->json()->all();

        $validator = Validator::make($request->all(), [
            'customername' => 'required|string',
            'phone_number' => 'string',
            'qty' => 'required|integer',
            'tax' => 'string',
            'discountvalue' => 'required|string',
            'subtotal' => 'required|integer',
            'total' => 'required|integer',
            'user_id' => 'required|integer',
            'pickup_address' => 'required|string',
            'pickup_time' => 'required|string',
            'delivery_address' => 'required|string',
        ]);

        $order = new Order();
        $order->customername = $orderdata['customername'];
        $order->phone_number = $orderdata['phone_number'];
        $order->qty = $orderdata['qty'];
        $order->tax = $orderdata['tax'];
        $order->discountvalue = $orderdata['discountvalue'];
        $order->subtotal = $orderdata['subtotal'];
        $order->total = $orderdata['total'];
        $order->user_id = $orderdata['user_id'];
        $order->pickup_address = $orderdata['pickup_address'];
        $order->pickup_time = $orderdata['pickup_time'];
        $order->delivery_address = $orderdata['delivery_address'];

        $orderstatus = Orderstatus::where('isDefault', 1)->first();

        $orderstatus->orders()->save($order);

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'service_id' => 'required|integer',
            'item_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|double',
            'urgent' => 'required|boolean',
            'regular' => 'required|boolean',
        ]);

        for ($i = 0; $i < count($orderdata['clothList']); ++$i) {
            for ($j = 0; $j < count($orderdata['clothList'][$i]['itemQuantity']); ++$j) {
                $orderitem = new OrderItem();
                $orderitem->order_id = $order->id;
                $orderitem->service_id = implode(', ', $orderdata['clothList'][$i]['itemQuantity'][$j]['serviceType']);
                $orderitem->item_id = $orderdata['clothList'][$i]['itemId'];
                $orderitem->quantity = 1;
                $orderitem->price = $orderdata['clothList'][$i]['itemQuantity'][$j]['price'];

                if ($orderdata['clothList'][$i]['itemQuantity'][$j]['deliveryType'] == 'urgent') {
                    $orderitem->urgent = 1;
                    $orderitem->regular = 0;
                }
                if ($orderdata['clothList'][$i]['itemQuantity'][$j]['deliveryType'] == 'regular') {
                    $orderitem->urgent = 0;
                    $orderitem->regular = 1;
                }

                $orderitem->save();
            }
        }

        return response()->json([
        'message' => 'order created successfully',
    ], 200);
    }

    public function send_notification(Request $request)
    {
        $_REQUEST['token'] = 'dZDeXZ5bAm0:APA91bHAd7jlJSqnIlvgVALorZGWhEMUPI9YmF_Ez6k0SEzwuwDvN95j_utqzAibcUPiTsC43XhbLF1_o57YTrVXyzf9Sl1gX3jvIiS39QlidkcaCFmiY7Xl8Uw3np4idJnwlBkivKbx';
        // echo 'Hello';
        define('API_ACCESS_KEY', 'AAAAnjo7zAA:APA91bFpnQ8LLDFAN2E0yKSd3gXtgbktxXo-Wd2qcMDGht7WO8BJLWdmW_FxqzgzMjlzthJ0wO1wr5Pn-jfiPHSCPw2JDXKIsaa3JcgSWCzvuknG5IqKUqWkO81hR4OapyixbK7VLXVq');
        //   $registrationIds = ;
        //prep the bundle
        $msg = [
                'body' => 'Firebase Push Notification',
                'title' => 'akta title',
                  ];
        $fields = [
                        'to' => $_REQUEST['token'],
                        'notification' => $msg,
                    ];

        $headers = [
                        'Authorization: key='.API_ACCESS_KEY,
                        'Content-Type: application/json',
                    ];
        //Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);

        return response()->json(['messange' => $fields]);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
