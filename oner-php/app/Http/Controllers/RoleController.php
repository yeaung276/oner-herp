<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    
    public function all()
    {
        $roles = role::all();
        return $this->respond('done', $roles);
    }

    public function get($id)
    {
        $role = role::find($id);
        if(is_null($role)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$role);
        
        
    }
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required|unique:role'
        ]);

        try {

            $role = $request->all();
            Role::insert($role);

            //return successful response
            return $this->respond('created', $role);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
         ]);
        $role = Role::find($id);
        if(is_null($role)){
            return $this->respond('not_found');
        }
        $role->update($request->all());
        return $this->respond('done', $role);

        
    }

    public function remove($id)
	{
		$role = role::find($id);
		if(is_null($role)){
            return $this->respond('not_found');
		}
		role::destroy($id);
        return $this->respond('removed',$role);

	}

    
}