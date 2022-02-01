<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InvestigationDepartment;

class InvestigationDepartmentController extends Controller
{
    // get all data
    public function all()
    {
        $investigationdepartments = InvestigationDepartment::all();
        return $this->respond('done', $investigationdepartments);
    }
    // retrieve single data
    public function get($id)
    {
        $investigationdepartment = InvestigationDepartment::find($id);
        if(is_null($investigationdepartment)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$investigationdepartment);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
           
        ]);

        try {
            $investigationdepartment = $request->all();

            InvestigationDepartment::insert($investigationdepartment);
            //return successful response
            return $this->respond('created', $investigationdepartment);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
         ]);
        $investigationdepartment = InvestigationDepartment::find($id);
        if(is_null($investigationdepartment)){
            return $this->respond('not_found');
        }
        $investigationdepartment->update($request->all());
        return $this->respond('done', $investigationdepartment);
    }
    // remove single row
    public function remove($id)
	{
		$investigationdepartment = InvestigationDepartment::find($id);
		if(is_null($investigationdepartment)){
            return $this->respond('not_found');
		}
		InvestigationDepartment::destroy($id);
        return $this->respond('removed',$investigationdepartment);

	}

    
}