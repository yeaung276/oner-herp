<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PharmacyWarehouse;
use Illuminate\Support\Facades\Auth;

class PharmacyWarehouseController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacywarehouses = PharmacyWarehouse::all();
        return $this->respond('done', $pharmacywarehouses);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacywarehouse = PharmacyWarehouse::find($id);
        if(is_null($pharmacywarehouse)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$pharmacywarehouse);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
           'phone' => 'required',
           'address' => 'required',
        ]);

        try {
            $pharmacywarehouse = $request->all();
            $pharmacywarehouse['created_user_id'] = Auth::user()->id;
            $pharmacywarehouse['updated_user_id'] = 0;
            PharmacyWarehouse::insert($pharmacywarehouse);
            //return successful response
            return $this->respond('created', $pharmacywarehouse);
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
            'phone' => 'required',
            'address' => 'required',
         ]);
        $pharmacywarehouse = PharmacyWarehouse::find($id);
        if(is_null($pharmacywarehouse)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacywarehouse->update($requestData);
        return $this->respond('done', $pharmacywarehouse);
    }
    // remove single row
    public function remove($id)
	{
		$pharmacywarehouse = PharmacyWarehouse::find($id);
		if(is_null($pharmacywarehouse)){
            return $this->respond('not_found');
		}
		PharmacyWarehouse::destroy($id);
        return $this->respond('removed',$pharmacywarehouse);
	}
}