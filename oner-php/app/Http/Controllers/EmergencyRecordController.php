<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\EmergencyRecord;

class EmergencyRecordController extends Controller
{
    // get all data
    public function all()
    {
        $emergencyrecords = EmergencyRecord::with('patient')->get();
        return $this->respond('done', $emergencyrecords);
    }
    // retrieve single data
    public function get($id)
    {
        $emergencyrecord = EmergencyRecord::with('patient')->find($id);
        if(is_null($emergencyrecord)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$emergencyrecord);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'patient_id' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $emergencyrecord = $request->all();

            EmergencyRecord::insert($emergencyrecord);
            //return successful response
            return $this->respond('created', $emergencyrecord);
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
         ]);
        $emergencyrecord = EmergencyRecord::find($id);
        if(is_null($emergencyrecord)){
            return $this->respond('not_found');
        }
        $emergencyrecord->update($request->all());
        return $this->respond('done', $emergencyrecord);
    }
    // remove single row
    public function remove($id)
	{
		$emergencyrecord = EmergencyRecord::find($id);
		if(is_null($emergencyrecord)){
            return $this->respond('not_found');
		}
		EmergencyRecord::destroy($id);
        return $this->respond('removed',$emergencyrecord);

	}

    
}