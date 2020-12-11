<?php

namespace App\Http\Controllers;

use App\Notice;
use App\Notifications\NoticeUsers;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();

        return view('notice.index', compact('notices'));
    }

    public function create()
    {
        $users = User::all();

        return view('notice.create', compact('users'));
    }

    public function store(Request $request)
    {
        $access_token = 'AAAAnjo7zAA:APA91bFpnQ8LLDFAN2E0yKSd3gXtgbktxXo-Wd2qcMDGht7WO8BJLWdmW_FxqzgzMjlzthJ0wO1wr5Pn-jfiPHSCPw2JDXKIsaa3JcgSWCzvuknG5IqKUqWkO81hR4OapyixbK7VLXVq';
        // print_r($request->users);
        // dd(json_decode(json_encode($request->users)));

        $validator = Validator::make($request->all(), [
            'user_id*' => 'required',
            'title' => 'required|string',
            'file_name' => 'string',
            'text' => 'string',
            'create_id' => 'required|integer',
        ]);

        $fileName = '';
        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time().'.'.$extension;
            $path = public_path().'/noticefile';
            $uplaod = $file->move($path, $fileName);
        }

        $notice = new Notice();
        $notice->user_id = json_encode(['data' => $request->users]);
        $notice->title = $request->input('title');
        $notice->file_name = $fileName;
        $notice->text = $request->input('text');
        $notice->create_id = Auth::user()->id;
        $notice->save();

        for ($j = 0; $j < count($request->users); ++$j) {
            $user = User::find($request->users[$j]);

            $data = [
            'to' => $user->deviceId,
            'notification' => [
                'title' => $request->input('title'),
                'body' => 'There is an announcement',
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

            $offerData = [
            'user_id' => $user->id,
            'create_id' => $notice->create_id,
            'title' => $notice->title,
            'text' => $notice->text,
            'notice_id' => $notice->id,
            'file_name' => $notice->file_name,
        ];
            $user->notify(new NoticeUsers($offerData));
        }

        return redirect('/notices')->with('success', 'Notice created!');
    }

    public function read_notice(Request $request)
    {
        $notice = Notice::find($request->notice_id);
        $notice->notice_read = $request->read;
        $notice->save();

        return response()->json(['notice' => $notice]);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
