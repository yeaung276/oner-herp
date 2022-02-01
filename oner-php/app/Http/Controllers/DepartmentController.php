<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Department;

class DepartmentController extends Controller
{
    // get all data
    public function all()
    {
        $departments = Department::all();
        return $this->respond('done', $departments);
    }
    // retrieve single data
    public function get($id)
    {
        $department = Department::find($id);
        if(is_null($department)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$department);
        
        
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required|unique:department'
        ]);

        try {
            $department = $request->all();
            Department::insert($department);
            //return successful response
            return $this->respond('created', $department);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
         ]);
        $department = Department::find($id);
        if(is_null($department)){
            return $this->respond('not_found');
        }
        $department->update($request->all());
        return $this->respond('done', $department);
    }
    // remove single row
    public function remove($id)
	{
		$department = Department::find($id);
		if(is_null($department)){
            return $this->respond('not_found');
		}
		Department::destroy($id);
        return $this->respond('removed',$department);

	}

    
}