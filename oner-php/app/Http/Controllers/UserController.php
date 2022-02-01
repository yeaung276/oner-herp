<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function all()
    {
        $users = User::all();
        return $this->respond('done', $users);
    }

    public function get($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$user);
        
        
    }
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'fullname' => 'required|string',
            // 'username' => 'required|unique:users',
            // 'password' => 'required|confirmed',
            'level'    => 'required',
        ]);

        try {

            $user = new User;
            $user->fullname = $request->input('fullname');
            $user->username = $request->input('username');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->created_user_id = Auth::user()->id;
            $user->save();

            //return successful response
            return $this->respond('created', $user);


        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'fullname'  => 'required|string',
            'username'  => 'required',
            'password'  => 'required|confirmed',
            'level'     => 'required',
        ]);
        $user = User::find($id);
        
        if(is_null($user)){
            return $this->respond('not_found');
        }
        $user->fullname = $request->input('fullname');
        $user->username = $request->input('username');
        $plainPassword = $request->input('password');
        $user->password = app('hash')->make($plainPassword);
        $user->updated_user_id = Auth::user()->id;
        $user->update();
        // $user->update($request->all());
        return $this->respond('done', $user);
    }

    public function remove($id)
	{
		$user = User::find($id);
		if(is_null($user)){
            return $this->respond('not_found');
		}
		$user::destroy($id);
        return $this->respond('removed',$user);

	}

    
}