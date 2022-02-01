<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\StoreLocation;

class StoreLocationController extends Controller
{
    // get all data
    public function all()
    {
        $storelocations = StoreLocation::get();
        return $this->respond('done', $storelocations);
    }
    // retrieve single data
    public function get($id)
    {
        $storelocation = StoreLocation::find($id);
        if(is_null($storelocation)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$storelocation);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $storelocation = $request->all();

            StoreLocation::insert($storelocation);
            //return successful response
            return $this->respond('created', $storelocation);
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
        $storelocation = StoreLocation::find($id);
        if(is_null($storelocation)){
            return $this->respond('not_found');
        }
        $storelocation->update($request->all());
        return $this->respond('done', $storelocation);
    }
    // remove single row
    public function remove($id)
	{
		$storelocation = StoreLocation::find($id);
		if(is_null($storelocation)){
            return $this->respond('not_found');
		}
		StoreLocation::destroy($id);
        return $this->respond('removed',$storelocation);

	}

    
}