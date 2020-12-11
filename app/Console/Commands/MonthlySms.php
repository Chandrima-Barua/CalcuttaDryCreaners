<?php

namespace App\Console\Commands;

use App\Order;
use App\Orderstatus;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MonthlySms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Monthly sms to all users for late pickup of orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = today()->format('Y-m-d');
        $orders = Order::where('due_date', '<', $date)->get();
        $apiKey = 'U2hlaWtoOlNoZWlraFJhODky';

        foreach ($orders as $order) {
            $status = Orderstatus::where('id', '=', $order['orderstatus_id'])->get();
            $deliver_day = Carbon::parse($order['due_date'])->format('d');
            $today = today()->format('d');
            // print($today);
            // print_r($status['slug']);
            // if(($order['orderstatus_id']) || ($status['slug'] == 'ready-in-shop')){
            if($today == $deliver_day){
            if($status['slug'] == 'ready-in-shop') {

                $url = 'https://smspanellogin.com/api/bulkSmsApi';

                $smsdata = [
                 'sender_id' => '52',
                 'apiKey' => $apiKey,
                 'mobileNo' => $order->phone_number,
                 'message' => 'Order no.'.' '.$order->id.' '.'is '.' '.$status['title'],
                 ];
                // print_r($smsdata);
        
                // $headers = [];
                // $headers[] = 'Content-type: application/json';
                // $headers[] = 'Connection: Keep-Alive';
                // // $curl = \curl_init($url);
                // $curl = curl_init($url);
                // curl_setopt($curl, CURLOPT_POSTFIELDS, $smsdata);
                // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                // curl_setopt($curl, CURLOPT_VERBOSE, true);
                // curl_exec($curl);

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
            }
        }
        }
    }
}
