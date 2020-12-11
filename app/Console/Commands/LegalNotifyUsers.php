<?php

namespace App\Console\Commands;

use App\Notifications\LegalExpire;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LegalNotifyUsers extends Command
{
    protected $signature = 'users:notify';

    protected $description = 'Send notification to all the selected users regarding legal documents expired date!';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $access_token = 'AAAAnjo7zAA:APA91bFpnQ8LLDFAN2E0yKSd3gXtgbktxXo-Wd2qcMDGht7WO8BJLWdmW_FxqzgzMjlzthJ0wO1wr5Pn-jfiPHSCPw2JDXKIsaa3JcgSWCzvuknG5IqKUqWkO81hR4OapyixbK7VLXVq';

        $users = User::whereNotNull('deadline_date')->get();

        foreach ($users as $user) {
            $to = \Carbon\Carbon::createFromFormat('Y-m-d', Carbon::now()->toDateString());
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $user->deadline_date);
            $diff_in_days = $to->diffInDays($from);
            $words = [
                'user_id' => $user->id,
                'days_left' => $diff_in_days,
            ];

            $unread = $user->unreadNotifications->where('type', 'App\Notifications\LegalExpire')->count();

            if (($diff_in_days >= 0) && ($unread == 0)) {
                
                $data = [
                'to' => $user->deviceId,
                'notification' => [
                    'title' => 'Your legal expiration has',
                    'body' => $diff_in_days.' '.'day(s) left!',
                    ],
            ];
                // $dataString = json_encode($data);

                // $headers = [
                //             'Authorization: key='.API_ACCESS_KEY,
                //             'Content-Type: application/json',
                //         ];

                // $ch = curl_init();

                // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                // curl_setopt($ch, CURLOPT_POST, true);
                // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                // curl_exec($ch);
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

                $offerData = [
                'firstname' => $user->firstname,
                'body' => 'Order status has been changed.',
                'thanks' => 'Thank you',
                'user_id' => $user->id,
            ];

                $user->notify(new LegalExpire($words));
            }
        }
        $this->info('Daily Update has been send successfully');
    }
}
