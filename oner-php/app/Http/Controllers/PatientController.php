<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Patient;

class PatientController extends Controller
{
    // get all data
    public function all()
    {
        $patients = Patient::all();
        return $this->respond('done', $patients);
    }
    // retrieve single data
    public function get($id)
    {
        $patient = Patient::with('medical_record')->find($id);
        if(is_null($patient)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$patient);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
           // 'nrc' => 'required',
           'phone' => 'required',
           'age' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $patient = $request->all();

            // if($patient['status']=='1'){
            //     //validate incoming request 
            //     $this->validate($request, [
            //         'date_of_birth' => 'required',
            //         'address' => 'required',
            //         'blood_group' => 'required',
            //         'gender' => 'required',
            //     ]);
            // }
            $id = Patient::insertGetId($patient);
            $patient_ = Patient::find($id);
            $patient_['patient_id'] = $patient_['id'] - 7697;
            $patient_->save();
            //return successful response
            return $this->respond('created', $patient_);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'nrc' => 'required',
            'phone' => 'required',
            'age' => 'required',
         ]);
        $patient = Patient::find($id);
        if(is_null($patient)){
            return $this->respond('not_found');
        }
        $patient->update($request->all());
        return $this->respond('done', $patient);
    }
    // remove single row
    public function remove($id)
	{
		$patient = Patient::find($id);
		if(is_null($patient)){
            return $this->respond('not_found');
		}
		Patient::destroy($id);
        return $this->respond('removed',$patient);

	}

    
}