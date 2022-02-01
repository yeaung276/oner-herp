<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DiagnosisRequest;
use Illuminate\Support\Facades\Auth;

class DiagnosisRequestController extends Controller
{
    // get all data
    public function all()
    {
        $diagnosisrequests = DiagnosisRequest::all();
        return $this->respond('done', $diagnosisrequests);
    }
    // retrieve single data
    public function get($id)
    {
        $diagnosisrequest = DiagnosisRequest::find($id);
        if(is_null($diagnosisrequest)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$diagnosisrequest);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'patient_id' => 'required',
           'date' => 'required',
           'doctor_id' => 'required',   
           'status' => 'required',   
        ]);

        try {
            $diagnosisrequest = $request->all();
            $diagnosisrequest['created_user_id'] = Auth::user()->id;
            $diagnosisrequest['updated_user_id'] = 0;
            DiagnosisRequest::insert($diagnosisrequest);
            //return successful response
            return $this->respond('created', $diagnosisrequest);
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
            'date' => 'required',
            'doctor_id' => 'required',   
            'status' => 'required',   
         ]);
        $diagnosisrequest = DiagnosisRequest::find($id);
        if(is_null($diagnosisrequest)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $diagnosisrequest->update($requestData);
        return $this->respond('done', $diagnosisrequest);
    }
    // remove single row
    public function remove($id)
	{
		$diagnosisrequest = DiagnosisRequest::find($id);
		if(is_null($diagnosisrequest)){
            return $this->respond('not_found');
		}
		DiagnosisRequest::destroy($id);
        return $this->respond('removed',$diagnosisrequest);
	}
}