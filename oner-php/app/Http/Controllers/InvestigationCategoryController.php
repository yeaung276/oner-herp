<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InvestigationCategory;

class InvestigationCategoryController extends Controller
{
    // get all data
    public function all()
    {
        $investigationcategorys = InvestigationCategory::with('items.service_item')->get();
        return $this->respond('done', $investigationcategorys);
    }
    // retrieve single data
    public function get($id)
    {
        $investigationcategory = InvestigationCategory::find($id);
        if(is_null($investigationcategory)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$investigationcategory);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'investigation_category_name' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $investigationcategory = $request->all();

            InvestigationCategory::insert($investigationcategory);
            //return successful response
            return $this->respond('created', $investigationcategory);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'investigation_category_name' => 'required',
         ]);
        $investigationcategory = InvestigationCategory::find($id);
        if(is_null($investigationcategory)){
            return $this->respond('not_found');
        }
        $investigationcategory->update($request->all());
        return $this->respond('done', $investigationcategory);
    }
    // remove single row
    public function remove($id)
	{
		$investigationcategory = InvestigationCategory::find($id);
		if(is_null($investigationcategory)){
            return $this->respond('not_found');
		}
		InvestigationCategory::destroy($id);
        return $this->respond('removed',$investigationcategory);

	}

    
}