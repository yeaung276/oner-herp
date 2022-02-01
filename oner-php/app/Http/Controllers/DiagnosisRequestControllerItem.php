<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DiagnosisRequestItem;
use Illuminate\Support\Facades\Auth;

class DiagnosisRequestItemController extends Controller
{
    // get all data
    public function all()
    {
        $diagnosis_requestitems = DiagnosisRequestItem::all();
        return $this->respond('done', $diagnosis_requestitems);
    }
    // retrieve single data
    public function get($id)
    {
        $diagnosis_requestitem = DiagnosisRequestItem::find($id);
        if(is_null($diagnosis_requestitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$diagnosis_requestitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'diagnosis_request_id' => 'required',
           'diagnosis_item_id' => 'required',
           'charge' => 'required',
        ]);

        try {
            $diagnosis_requestitem = $request->all();
            // $diagnosis_requestitem['created_user_id'] = Auth::user()->id;
            // $diagnosis_requestitem['updated_user_id'] = 0;
            DiagnosisRequestItem::insert($diagnosis_requestitem);
            //return successful response
            return $this->respond('created', $diagnosis_requestitem);
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
            'diagnosis_request_id' => 'required',
            'diagnosis_item_id' => 'required',
            'charge' => 'required',  
         ]);
        $diagnosis_requestitem = DiagnosisRequestItem::find($id);
        if(is_null($diagnosis_requestitem)){
            return $this->respond('not_found');
        }
        // $requestData['updated_user_id'] = Auth::user()->id;
        $diagnosis_requestitem->update($requestData);
        return $this->respond('done', $diagnosis_requestitem);
    }
    // remove single row
    public function remove($id)
	{
		$diagnosis_requestitem = DiagnosisRequestItem::find($id);
		if(is_null($diagnosis_requestitem)){
            return $this->respond('not_found');
		}
		DiagnosisRequestItem::destroy($id);
        return $this->respond('removed',$diagnosis_requestitem);
	}
}