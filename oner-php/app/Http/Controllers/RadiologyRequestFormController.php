<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\RadiologyRequestForm;
use Illuminate\Support\Facades\Auth;

class RadiologyRequestFormController extends Controller
{
    // get all data
    public function all()
    {
        $radiology_request_forms = RadiologyRequestForm::all();
        return $this->respond('done', $radiology_request_forms);
    }
    // retrieve single data
    public function get($id)
    {
        $radiology_request_form = RadiologyRequestForm::find($id);
        if(is_null($radiology_request_form)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$radiology_request_form);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'type' => 'required',
           'patient_id' => 'required',
        ]);

        try {
            $radiology_request_form = $request->all();
            $radiology_request_form['created_user_id'] = Auth::user()->id;
            $radiology_request_form['updated_user_id'] = 0;
            RadiologyRequestForm::insert($radiology_request_form);
            //return successful response
            return $this->respond('created', $radiology_request_form);
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
            'type' => 'required',
            'patient_id' => 'required',  
         ]);
        $radiology_request_form = RadiologyRequestForm::find($id);
        if(is_null($radiology_request_form)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $radiology_request_form->update($requestData);
        return $this->respond('done', $radiology_request_form);
    }
    // remove single row
    public function remove($id)
	{
		$radiology_request_form = RadiologyRequestForm::find($id);
		if(is_null($radiology_request_form)){
            return $this->respond('not_found');
		}
		RadiologyRequestForm::destroy($id);
        return $this->respond('removed',$radiology_request_form);
	}
}