<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ServiceCategory;

class ServiceCategoryController extends Controller
{
    // get all data
    public function all()
    {
        $servicecategorys = ServiceCategory::all();
        return $this->respond('done', $servicecategorys);
    }
    // retrieve single data
    public function get($id)
    {
        $servicecategory = ServiceCategory::find($id);
        if(is_null($servicecategory)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$servicecategory);
        
        
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required|unique:service_category'
        ]);

        try {
            $servicecategory = $request->all();
            ServiceCategory::insert($servicecategory);
            //return successful response
            return $this->respond('created', $servicecategory);
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
        $servicecategory = ServiceCategory::find($id);
        if(is_null($servicecategory)){
            return $this->respond('not_found');
        }
        $servicecategory->update($request->all());
        return $this->respond('done', $servicecategory);
    }
    // remove single row
    public function remove($id)
	{
		$servicecategory = ServiceCategory::find($id);
		if(is_null($servicecategory)){
            return $this->respond('not_found');
		}
		ServiceCategory::destroy($id);
        return $this->respond('removed',$servicecategory);

	}

    
}