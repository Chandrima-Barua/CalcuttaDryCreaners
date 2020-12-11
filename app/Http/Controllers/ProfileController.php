<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        $profile = Auth::user()->profile;
        return view('profile')->with(['user' => $user, 'profile' => $profile]);
    }

  
  
    public function update(Request $request)
    {

        $user = Auth::user();
        $currentEmail = Auth::user()->email;
        $user = Auth::user();
        $profile = $user->profile;
        
        $validator = Validator::make($request->all(), array(
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'email' => 'required|email',
            'profilePicture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'required|string|max:255',
        ));

        if($validator->fails()){

            return redirect(route('user.profile'))->withErrors($validator)->withInput();
        }

        $user->email = $request->input('email');

        if($request->has('password')){

        }
        $fileName ='';
        if ($request->hasFile('profilePicture')){
            $file = $request->file('profilePicture');
           $extension = $file->getClientOriginalExtension(); // you can also use file name
           $fileName = time().'.'.$extension;
           $path = public_path().'/profile_pictures';
           $uplaod = $file->move($path,$fileName);
         }
        
        

        $profile->firstName = $request->input('firstname');
        $profile->lastName = $request->input('lastname');
        $profile->gender = $request->input('gender');
        $profile->street = $request->input('street');
        $profile->street1 = $request->input('street1');
        $profile->area = $request->input('area');
        $profile->city = $request->input('city');
        $profile->zip = $request->input('zip');
        $profile->profilePicture = $fileName;
        $profile->phone = $request->input('phone');

        $user->firstName = $request->input('firstname');
        $user->lastName = $request->input('lastname');
        $user->email = $request->input('email');
        try{
            $user->save();
            $profile->save();
            return redirect(route('user.profile'))->with('successes', ['Successfully updated profile!']);
        }catch (QueryException $e){
            $validator->errors()->add('could_not_save', 'Could not save profile due to database issue!');
            return redirect(route('user.profile'))->withErrors($validator)->withInput();
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
