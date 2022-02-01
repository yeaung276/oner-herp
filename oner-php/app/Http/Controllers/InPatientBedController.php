<?php

namespace App\Http\Controllers;

use App\InpatientBed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InPatientBedController extends Controller
{
    // get all data
    public function all()
    {
        $inpatientbeds = InpatientBed::with('room')->get();
        return $this->respond('done', $inpatientbeds);
    }
    // retrieve single data
    public function get($id)
    {
        $inpatientbed = InpatientBed::with('room')->find($id);
        if(is_null($inpatientbed)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$inpatientbed);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'bed_name' => 'required',
        ]);

        try {
            $inpatientbed = $request->all();
            $inpatientbed['created_user_id'] = Auth::user()->id;
            $inpatientbed['updated_user_id'] = 0;
            InpatientBed::insert($inpatientbed);
            //return successful response
            return $this->respond('created', $inpatientbed);
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
            'bed_name' => 'required',
         ]);
        $inpatientbed = InpatientBed::find($id);
        if(is_null($inpatientbed)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $inpatientbed->update($requestData);
        return $this->respond('done', $inpatientbed);
    }
    // remove single row
    public function remove($id)
	{
		$inpatientbed = InpatientBed::find($id);
		if(is_null($inpatientbed)){
            return $this->respond('not_found');
		}
		InpatientBed::destroy($id);
        return $this->respond('removed',$inpatientbed);
	}
}