<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PharmacyUnitConversion;
use Illuminate\Support\Facades\Auth;

class PharmacyUnitConversionController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacyunitconversions = PharmacyUnitConversion::all();
        return $this->respond('done', $pharmacyunitconversions);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacyunitconversion = PharmacyUnitConversion::find($id);
        if(is_null($pharmacyunitconversion)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$pharmacyunitconversion);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'pharmacy_item_id'=>'required',
            'sku_name'=>'required',
            'sku_quantity'=>'required',
            'po_uom_name'=>'required',
            'po_uom_quantity'=>'required',
           
        ]);

        try {
            $pharmacyunitconversion = $request->all();
            $pharmacyunitconversion['created_user_id'] = Auth::user()->id;
            $pharmacyunitconversion['updated_user_id'] = 0;
            PharmacyUnitConversion::insert($pharmacyunitconversion);
            //return successful response
            return $this->respond('created', $pharmacyunitconversion);
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
            'sku_name'=>'required',
            'sku_quantity'=>'required',
            'po_uom_name'=>'required',
            'po_uom_quantity'=>'required',
           
        ]);
        $pharmacyunitconversion = PharmacyUnitConversion::find($id);
        if(is_null($pharmacyunitconversion)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacyunitconversion->update($requestData);
        return $this->respond('done', $pharmacyunitconversion);
    }
    // remove single row
    public function remove($id)
	{
		$pharmacyunitconversion = PharmacyUnitConversion::find($id);
		if(is_null($pharmacyunitconversion)){
            return $this->respond('not_found');
		}
		PharmacyUnitConversion::destroy($id);
        return $this->respond('removed',$pharmacyunitconversion);
	}
}