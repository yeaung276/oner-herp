<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PharmacyCategory;
use Illuminate\Support\Facades\Auth;

class PharmacyCategoryController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacycategorys = PharmacyCategory::all();
        return $this->respond('done', $pharmacycategorys);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacycategory = PharmacyCategory::find($id);
        if(is_null($pharmacycategory)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$pharmacycategory);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
        ]);

        try {
            $pharmacycategory = $request->all();
            $pharmacycategory['created_user_id'] = Auth::user()->id;
            $pharmacycategory['updated_user_id'] = 0;
            PharmacyCategory::insert($pharmacycategory);
            //return successful response
            return $this->respond('created', $pharmacycategory);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $requestData = $request->all();
        $this->validate($request, [
            'name' => 'required',
         ]);
        $pharmacycategory = PharmacyCategory::find($id);
        if(is_null($pharmacycategory)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacycategory->update($requestData);
        return $this->respond('done', $pharmacycategory);
    }
    // remove single row
    public function remove($id)
	{
		$pharmacycategory = PharmacyCategory::find($id);
		if(is_null($pharmacycategory)){
            return $this->respond('not_found');
		}
		PharmacyCategory::destroy($id);
        return $this->respond('removed',$pharmacycategory);
	}
}