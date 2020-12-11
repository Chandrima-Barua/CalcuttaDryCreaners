<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Item;
use App\Notice;
use App\Orderstatus;
use App\Service;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = date('Y-m-d', strtotime(Carbon::today()));
        $services = Service::all();
        $users = User::all();
        $branches = Branch::all();

        $notices = Notice::whereRaw('created_at = (select max(`created_at`) from notices)')->get();

        $noticedata = DB::table('notifications')
        ->select('*')
        ->where('type', 'App\Notifications\NoticeUsers')
        ->where('notifiable_id', Auth::user()->id)
        ->where('read_at', null)
        ->orderBy('created_at', 'DESC')->first();

        $notifications = (array) json_decode(json_encode($noticedata));
        // dd($notifications);
        $items = Item::select('items.*', 'items.name as item_name', 'services.name as service_name')
        ->join('services', 'services.id', '=', 'items.service_id')
        ->get();

        //for getting per day pieces of cloths
        $orderitems = Item::select('items.*', 'items.name as item_name', 'order_items.*')
        ->join('order_items', 'order_items.item_id', '=', 'items.id')
        ->selectRaw('count(order_items.quantity) as quantity')
        ->where('date', $today)->groupby('item_id')
        ->get();
        // dd($notices);

        //for getting delivered order details of every branch
        // $branchorder = Orderstatus::select('orderstatuses.*','orderstatuses.title as status')->join('orders', 'orders.orderstatus_id', '=', 'orderstatuses.id')->selectRaw('count(orders.id) as number')->where('orderstatuses.slug', 'delivered')->groupby('orders.branch_id')->get();
        $branchorder = Orderstatus::select('orderstatuses.*', 'orderstatuses.title as status', 'orders.*', 'branches.name as branch')
        ->join('orders', 'orders.orderstatus_id', '=', 'orderstatuses.id')
        ->join('branches', 'branches.id', '=', 'orders.branch_id')
        ->selectRaw('count(orders.id) as order_number')
        ->where('orderstatuses.slug', 'delivered')
        ->groupby('orders.branch_id')
        ->get();
        // dd($branchorder);

        return view('home')->with(['services' => $services, 'items' => $items, 'users' => $users, 'branches' => $branches, 'orderitems' => $orderitems, 'branchorder' => $branchorder, 'notices' => $notices, 'notifications' => $notifications]);
    }

    public function saveToken(Request $request)
    {
        $user = User::find($request->user_id);

        $prevdeviceid = $user->deviceId;
        if ($user) {
            if ($prevdeviceid != $request->token) {
                $user->deviceId = $request->token;
                $user->save();

                return response()->json([
                'message' => 'User token updated',
            ]);
            } else {
                return response()->json([
                'message' => 'User token existed!',
            ]);
            }
        } else {
            return response()->json([
            'message' => 'Error!',
        ]);
        }
    }
}
