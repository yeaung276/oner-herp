<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\EmergencyBed;

class EmergencyBedController extends Controller
{
    // get all data
    public function all()
    {
        $emergencybeds = EmergencyBed::with('room')->get();
        return $this->respond('done', $emergencybeds);
    }
    // retrieve single data
    public function get($id)
    {
        $emergencybed = EmergencyBed::with('room')->find($id);
        if(is_null($emergencybed)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$emergencybed);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'emergency_room_id' => 'required',
           'location' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $emergencybed = $request->all();

            EmergencyBed::insert($emergencybed);
            //return successful response
            return $this->respond('created', $emergencybed);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'emergency_room_id' => 'required',
            'location' => 'required',
         ]);
        $emergencybed = EmergencyBed::find($id);
        if(is_null($emergencybed)){
            return $this->respond('not_found');
        }
        $emergencybed->update($request->all());
        return $this->respond('done', $emergencybed);
    }
    // remove single row
    public function remove($id)
	{
		$emergencybed = EmergencyBed::find($id);
		if(is_null($emergencybed)){
            return $this->respond('not_found');
		}
		EmergencyBed::destroy($id);
        return $this->respond('removed',$emergencybed);

	}

    
}