<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PharmacyIssueItem;
use Illuminate\Support\Facades\Auth;

class PharmacyIssueItemController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacyissueitems = PharmacyIssueItem::all();
        return $this->respond('done', $pharmacyissueitems);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacyissueitem = PharmacyIssueItem::find($id);
        if(is_null($pharmacyissueitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$pharmacyissueitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'pharmacy_issue_id' => 'required',
           'pharmacy_item_id' => 'required',
           'quantity' => 'required',
           'sale_price' => 'required',
           'amount' => 'required',
        ]);

        try {
            $pharmacyissueitem = $request->all();
            $pharmacyissueitem['created_user_id'] = Auth::user()->id;
            $pharmacyissueitem['updated_user_id'] = 0;
            $id = PharmacyIssueItem::insertGetId($pharmacyissueitem);
            $pharmacyissueitem['id'] = $id;
            //return successful response
            return $this->respond('created', $pharmacyissueitem);
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
            'pharmacy_issue_id' => 'required',
            'pharmacy_item_id' => 'required',
            'quantity' => 'required',
            'sale_price' => 'required',
            'amount' => 'required',
        ]);
        $pharmacyissueitem = PharmacyIssueItem::find($id);
        if(is_null($pharmacyissueitem)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacyissueitem->update($requestData);
        return $this->respond('done', $pharmacyissueitem);
    }
    // remove single row
    public function remove($id)
	{
		$pharmacyissueitem = PharmacyIssueItem::find($id);
		if(is_null($pharmacyissueitem)){
            return $this->respond('not_found');
		}
		PharmacyIssueItem::destroy($id);
        return $this->respond('removed',$pharmacyissueitem);
	}
}