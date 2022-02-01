<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\EmergencyPatient;

class EmergencyPatientController extends Controller
{
    // get all data
    public function all()
    {
        $emergencypatients = EmergencyPatient::with('patient')->get();
        return $this->respond('done', $emergencypatients);
    }
    // retrieve single data
    public function get($id)
    {
        $emergencypatient = EmergencyPatient::with('patient')->find($id);
        if(is_null($emergencypatient)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$emergencypatient);
    }
    public function getOT()
    {
        $emergencypatients = EmergencyPatient::with('patient')->where('ot_labour','OT')->get();
        return $this->respond('done', $emergencypatients);
    }

    public function getLabour()
    {
        $emergencypatients = EmergencyPatient::with('patient')->where('ot_labour','LABOUR')->get();
        return $this->respond('done', $emergencypatients);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'patient_id' => 'required',
           'bed_id' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $emergencypatient = $request->all();

            $emergencypatient['id'] = EmergencyPatient::insertGetId($emergencypatient);
            //return successful response
            return $this->respond('created', $emergencypatient);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
           'patient_id' => 'required',
           'bed_id' => 'required',
         ]);
        $emergencypatient = EmergencyPatient::find($id);
        if(is_null($emergencypatient)){
            return $this->respond('not_found');
        }
        $emergencypatient->update($request->all());
        return $this->respond('done', $emergencypatient);
    }
    // remove single row
    public function remove($id)
	{
		$emergencypatient = EmergencyPatient::find($id);
		if(is_null($emergencypatient)){
            return $this->respond('not_found');
		}
		EmergencyPatient::destroy($id);
        return $this->respond('removed',$emergencypatient);

	}

    
}
