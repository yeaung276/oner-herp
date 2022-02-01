<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DiagnosisReport;
use Illuminate\Support\Facades\Auth;

class DiagnosisReportController extends Controller
{
    // get all data
    public function all()
    {
        $diagnosisreports = DiagnosisReport::all();
        return $this->respond('done', $diagnosisreports);
    }
    // retrieve single data
    public function get($id)
    {
        $diagnosisreport = DiagnosisReport::find($id);
        if(is_null($diagnosisreport)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$diagnosisreport);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'diagnosis_request_id' => 'required',
           'date' => 'required',
           'doctor_id' => 'required',
        ]);

        try {
            $diagnosisreport = $request->all();
            $diagnosisreport['created_user_id'] = Auth::user()->id;
            $diagnosisreport['updated_user_id'] = 0;
            DiagnosisReport::insert($diagnosisreport);
            //return successful response
            return $this->respond('created', $diagnosisreport);
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
            'date' => 'required',
            'doctor_id' => 'required',  
         ]);
        $diagnosisreport = DiagnosisReport::find($id);
        if(is_null($diagnosisreport)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $diagnosisreport->update($requestData);
        return $this->respond('done', $diagnosisreport);
    }
    // remove single row
    public function remove($id)
	{
		$diagnosisreport = DiagnosisReport::find($id);
		if(is_null($diagnosisreport)){
            return $this->respond('not_found');
		}
		DiagnosisReport::destroy($id);
        return $this->respond('removed',$diagnosisreport);
	}
}