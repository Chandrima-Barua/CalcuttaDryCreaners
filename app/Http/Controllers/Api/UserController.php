<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
use Session;
class UserController extends Controller
{
    public $successStatus = 200;


    public function login(Request $request){ 

        $phonenumber = $request->input('phonenumber');
        // $deviceId = $request->input('deviceId');


        // $device_id = User::where('deviceId', $deviceId)
        // ->select('users.deviceId as deviceId')
        // ->get()->toArray();
        
        $user = User::where('phonenumber', $phonenumber)
                   ->select('users.id as userId', 'users.userName as userName','users.address as address','users.deviceId as deviceId', 'users.phoneNumber as phoneNumber')
                   ->first();
        $user['api_key'] =  Auth::loginUsingId($user->userId)->createToken('MyApp')->accessToken; 

        // if($deviceId == $device_id[0]['deviceId']){

                if ($user) { 
                        return response()->json(['user' => $user, "userExists" => "true"]);  
                        
                }
                else{

                        return response()->json([
                        "userExists" => "false"]
                        );
                    }
        // }
        // else{
        //     $userupdate = User::where('deviceId', $deviceId)->first();
        //     $userupdate->phonenumber = $request->input('phonenumber');
        //     $userupdate->save();
        //     return response()->json(['userupdate' => $userupdate, "message" => "User's Phone Number Updated"]); 
        // }

 
}

    

 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'userName' => 'required|string',
            'phonenumber' => 'required|string', 
            'deviceId' => 'string',
            'address' => 'required|string'
            
        ]);

        if ($validator->fails()) { 

            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = new User();
        $user->userName = $request->input('userName');
        $user->phonenumber = $request->input('phonenumber');
        $user->deviceId = $request->input('deviceId');
        $user->address = $request->input('address');
        $user->save();
        $user['api_key'] =  $user->createToken('MyApp')->accessToken; 
        
        
        return response()->json(['user'=>$user], $this-> successStatus); 
    }



    public function show(Request $request)
    {
        $userid = $request->input('userId');
        $user= User::where('id', $userid)
        ->select('users.id as userId', 'users.userName as userName','users.address as address','users.deviceId as deviceId', 'users.phoneNumber as phoneNumber')
        ->get();
        
       if (!$user->isEmpty()) { 
                return response()->json(['user' => $user, "message" => "Success"]);  
            
           
        }
        else{

            return response()->json([
                "message" => "failed"]
            );
        }
    }

  
    public function update(Request $request)
    {
        
        $userid = $request->input('userid');
        $user = User::find($userid);
        
        if($request->has('phonenumber')){

            return response()->json([ "message" => "Please Login with new Phone number"]); 
            
        }
        else{
            $user->userName = $request->input('userName');
            $user->deviceId = encrypt($request->input('deviceId'));
            $user->address = $request->input('address');
            $user->save();
            

        }

        $updateduser= User::where('id', $id)
        ->select('users.id as userId', 'users.userName as userName','users.address as address','users.deviceId as deviceId', 'users.phoneNumber as phoneNumber')
        ->get();
        return response()->json(['user'=>$updateduser, "message" => "Success"]);  
      
    }

    public function getDeviceId(Request $request)
    {
        $userid = $request->input('userid');
        $deviceid = User::where('id', $userid)
        ->select('users.deviceId as deviceId')
        ->get();
        return response()->json($deviceid);


    }
    

    public function logout(Request $request)
    {
        Session::flash('message', 'This is a message!'); 
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}