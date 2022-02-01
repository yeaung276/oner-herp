<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DiagnosisReportItem;
use Illuminate\Support\Facades\Auth;

class DiagnosisReportItemController extends Controller
{
    // get all data
    public function all()
    {
        $diagnosis_reportitems = DiagnosisReportItem::all();
        return $this->respond('done', $diagnosis_reportitems);
    }
    // retrieve single data
    public function get($id)
    {
        $diagnosis_reportitem = DiagnosisReportItem::find($id);
        if(is_null($diagnosis_reportitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$diagnosis_reportitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'diagnosis_report_id' => 'required',
           'diagnosis_item_id' => 'required',
           'result' => 'required',
        ]);

        try {
            $diagnosis_reportitem = $request->all();
            // $diagnosis_reportitem['created_user_id'] = Auth::user()->id;
            // $diagnosis_reportitem['updated_user_id'] = 0;
            DiagnosisReportItem::insert($diagnosis_reportitem);
            //return successful response
            return $this->respond('created', $diagnosis_reportitem);
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
            'diagnosis_report_id' => 'required',
            'diagnosis_item_id' => 'required',
            'result' => 'required',  
         ]);
        $diagnosis_reportitem = DiagnosisReportItem::find($id);
        if(is_null($diagnosis_reportitem)){
            return $this->respond('not_found');
        }
        // $requestData['updated_user_id'] = Auth::user()->id;
        $diagnosis_reportitem->update($requestData);
        return $this->respond('done', $diagnosis_reportitem);
    }
    // remove single row
    public function remove($id)
	{
		$diagnosis_reportitem = DiagnosisReportItem::find($id);
		if(is_null($diagnosis_reportitem)){
            return $this->respond('not_found');
		}
		DiagnosisReportItem::destroy($id);
        return $this->respond('removed',$diagnosis_reportitem);
	}
}