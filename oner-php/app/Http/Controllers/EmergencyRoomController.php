<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\EmergencyRoom;

class EmergencyRoomController extends Controller
{
    // get all data
    public function all()
    {
        $emergencyrooms = EmergencyRoom::all();
        return $this->respond('done', $emergencyrooms);
    }
    // retrieve single data
    public function get($id)
    {
        $emergencyroom = EmergencyRoom::find($id);
        if(is_null($emergencyroom)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$emergencyroom);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'room_id' => 'required',
           'location' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $emergencyroom = $request->all();

            EmergencyRoom::insert($emergencyroom);
            //return successful response
            return $this->respond('created', $emergencyroom);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'room_id' => 'required',
            'location' => 'required',
         ]);
        $emergencyroom = EmergencyRoom::find($id);
        if(is_null($emergencyroom)){
            return $this->respond('not_found');
        }
        $emergencyroom->update($request->all());
        return $this->respond('done', $emergencyroom);
    }
    // remove single row
    public function remove($id)
	{
		$emergencyroom = EmergencyRoom::find($id);
		if(is_null($emergencyroom)){
            return $this->respond('not_found');
		}
		EmergencyRoom::destroy($id);
        return $this->respond('removed',$emergencyroom);

	}

    
}