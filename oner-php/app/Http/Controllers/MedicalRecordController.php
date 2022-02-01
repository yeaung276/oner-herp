<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\MedicalRecord;
use App\Patient;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    // get all data
    public function all()
    {
        $medicalrecords = MedicalRecord::with('patient')->get();
        return $this->respond('done', $medicalrecords);
    }
    // retrieve single data
    public function get($id)
    {
        $medicalrecord = MedicalRecord::with('patient')->find($id);
        if(is_null($medicalrecord)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$medicalrecord);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'record_type' => 'required',
           'patient_id' => 'required'
        ]);

        try {
            $medicalrecord = $request->all();
            $medicalrecord['created_user_id'] = Auth::user()->id;
            $medicalrecord['updated_user_id'] = 0;

            MedicalRecord::insert($medicalrecord);
            //return successful response
            return $this->respond('created', $medicalrecord);
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
            'record_type' => 'required',
            'patient_id' => 'required'
         ]);
        $medicalrecord = MedicalRecord::find($id);
        if(is_null($medicalrecord)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $medicalrecord->update($requestData);
        return $this->respond('done', $medicalrecord);
    }
    // remove single row
    public function remove($id)
	{
		$medicalrecord = MedicalRecord::find($id);
		if(is_null($medicalrecord)){
            return $this->respond('not_found');
		}
		MedicalRecord::destroy($id);
        return $this->respond('removed',$medicalrecord);

	}
    public function getpatienthistory($patientid){
        $medicalrecords = Patient::with('medical_record')->find($patientid);
        if(is_null($medicalrecords)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$medicalrecords);
    }
    
}