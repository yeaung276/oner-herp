<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    // get all data
    public function all()
    {
        $suppliers = Supplier::all();
        return $this->respond('done', $suppliers);
    }
    // retrieve single data
    public function get($id)
    {
        $supplier = Supplier::find($id);
        if(is_null($supplier)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$supplier);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'dealer' => 'required',
           'company' => 'required',
           'contact' => 'required'
        ]);

        try {
            $supplier = $request->all();
            $supplier['created_user_id'] = Auth::user()->id;
            $supplier['updated_user_id'] = 0;
            Supplier::insert($supplier);
            //return successful response
            return $this->respond('created', $supplier);
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

         ]);
        $supplier = Supplier::find($id);
        if(is_null($supplier)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $supplier->update($requestData);
        return $this->respond('done', $supplier);
    }
    // remove single row
    public function remove($id)
	{
		$supplier = Supplier::find($id);
		if(is_null($supplier)){
            return $this->respond('not_found');
		}
		Supplier::destroy($id);
        return $this->respond('removed',$supplier);
	}
}