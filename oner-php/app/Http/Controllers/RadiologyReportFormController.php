<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\RadiologyReportForm;
use Illuminate\Support\Facades\Auth;

class RadiologyReportFormController extends Controller
{
    // get all data
    public function all()
    {
        $radiology_report_forms = RadiologyReportForm::all();
        return $this->respond('done', $radiology_report_forms);
    }
    // retrieve single data
    public function get($id)
    {
        $radiology_report_form = RadiologyReportForm::find($id);
        if(is_null($radiology_report_form)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$radiology_report_form);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'patient_id' => 'required',           
           'type' => 'required',
        ]);

        try {
            $radiology_report_form = $request->all();
            $radiology_report_form['created_user_id'] = Auth::user()->id;
            $radiology_report_form['updated_user_id'] = 0;
            RadiologyReportForm::insert($radiology_report_form);
            //return successful response
            return $this->respond('created', $radiology_report_form);
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
            'patient_id' => 'required',
            'type' => 'required', 
         ]);
        $radiology_report_form = RadiologyReportForm::find($id);
        if(is_null($radiology_report_form)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $radiology_report_form->update($requestData);
        return $this->respond('done', $radiology_report_form);
    }
    // remove single row
    public function remove($id)
	{
		$radiology_report_form = RadiologyReportForm::find($id);
		if(is_null($radiology_report_form)){
            return $this->respond('not_found');
		}
		RadiologyReportForm::destroy($id);
        return $this->respond('removed',$radiology_report_form);
	}
}