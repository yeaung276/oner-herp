<?php

namespace App\Http\Controllers;

use App\InpatientRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InPatientRoomController extends Controller
{
    // get all data
    public function all()
    {
        $inpatientrooms = InpatientRoom::all();
        return $this->respond('done', $inpatientrooms);
    }
    // retrieve single data
    public function get($id)
    {
        $inpatientroom = InpatientRoom::find($id);
        if(is_null($inpatientroom)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$inpatientroom);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'room_no' => 'required',
        ]);

        try {
            $inpatientroom = $request->all();
            $inpatientroom['created_user_id'] = Auth::user()->id;
            $inpatientroom['updated_user_id'] = 0;
            InpatientRoom::insert($inpatientroom);
            //return successful response
            return $this->respond('created', $inpatientroom);
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
            'room_no' => 'required',
         ]);
        $inpatientroom = InpatientRoom::find($id);
        if(is_null($inpatientroom)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $inpatientroom->update($requestData);
        return $this->respond('done', $inpatientroom);
    }
    // remove single row
    public function remove($id)
	{
		$inpatientroom = InpatientRoom::find($id);
		if(is_null($inpatientroom)){
            return $this->respond('not_found');
		}
		InpatientRoom::destroy($id);
        return $this->respond('removed',$inpatientroom);
	}
}