<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PharmacyInventory;
use Illuminate\Support\Facades\Auth;

class PharmacyInventoryController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacyinventorys = PharmacyInventory::all();
        return $this->respond('done', $pharmacyinventorys);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacyinventory = PharmacyInventory::find($id);
        if(is_null($pharmacyinventory)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$pharmacyinventory);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'pharmacy_item_id'=>'required',
            'balance'=>'required',
            'average_price'=>'required',
            'purchasing_price'=>'required',
            
        ]);

        try {
            $pharmacyinventory = $request->all();
            $pharmacyinventory['created_user_id'] = Auth::user()->id;
            $pharmacyinventory['updated_user_id'] = 0;
            PharmacyInventory::insert($pharmacyinventory);
            //return successful response
            return $this->respond('created', $pharmacyinventory);
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
            'pharmacy_item_id'=>'required',
            'balance'=>'required',
            'average_price'=>'required',
            'purchasing_price'=>'required',
            
        ]);
        $pharmacyinventory = PharmacyInventory::find($id);
        if(is_null($pharmacyinventory)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacyinventory->update($requestData);
        return $this->respond('done', $pharmacyinventory);
    }
    // remove single row
    public function remove($id)
	{
		$pharmacyinventory = PharmacyInventory::find($id);
		if(is_null($pharmacyinventory)){
            return $this->respond('not_found');
		}
		PharmacyInventory::destroy($id);
        return $this->respond('removed',$pharmacyinventory);
	}
}