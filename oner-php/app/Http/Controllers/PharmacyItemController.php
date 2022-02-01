<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PharmacyItem;
use Illuminate\Support\Facades\Auth;

class PharmacyItemController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacyitems = PharmacyItem::with('pharmacy_category','pharmacy_unit_conversion','pharmacy_inventory','service_item')->get();
        return $this->respond('done', $pharmacyitems);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacyitem = PharmacyItem::with('pharmacy_category','pharmacy_unit_conversion','pharmacy_inventory','service_item')->find($id);
        if(is_null($pharmacyitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$pharmacyitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
           'pharmacy_category_id' => 'required',
           
        ]);

        try {
            $pharmacyitem = $request->all();
            $pharmacyitem['created_user_id'] = Auth::user()->id;
            $pharmacyitem['updated_user_id'] = 0;
            PharmacyItem::insert($pharmacyitem);
            //return successful response
            return $this->respond('created', $pharmacyitem);
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
            'pharmacy_category_id' => 'required',
         ]);
        $pharmacyitem = PharmacyItem::find($id);
        if(is_null($pharmacyitem)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacyitem->update($requestData);
        return $this->respond('done', $pharmacyitem);
    }
    // remove single row
    public function remove($id)
	{
		$pharmacyitem = PharmacyItem::find($id);
		if(is_null($pharmacyitem)){
            return $this->respond('not_found');
		}
		PharmacyItem::destroy($id);
        return $this->respond('removed',$pharmacyitem);
	}
}