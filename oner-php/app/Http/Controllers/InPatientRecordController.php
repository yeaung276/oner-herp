<?php

namespace App\Http\Controllers;

use App\InpatientRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InPatientRecordController extends Controller
{
    // get all data
    public function all()
    {
        $inpatientrecords = InpatientRecord::with('patient','bed.room')->get();
        return $this->respond('done', $inpatientrecords);
    }
    // retrieve single data
    public function get($id)
    {
        $inpatientrecord = InpatientRecord::with('patient','bed.room')->find($id);
        if(is_null($inpatientrecord)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$inpatientrecord);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'patient_id' => 'required',
            'admited_date' => 'required',
            'bed_id' => 'required',
        ]);

        try {
            $inpatientrecord = $request->all();
            $inpatientrecord['created_user_id'] = Auth::user()->id;
            $inpatientrecord['updated_user_id'] = 0;
            InpatientRecord::insert($inpatientrecord);
            //return successful response
            return $this->respond('created', $inpatientrecord);
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
            'admited_date' => 'required',
            'bed_id' => 'required',
         ]);
        $inpatientrecord = InpatientRecord::find($id);
        if(is_null($inpatientrecord)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $inpatientrecord->update($requestData);
        return $this->respond('done', $inpatientrecord);
    }
    // remove single row
    public function remove($id)
	{
		$inpatientrecord = InpatientRecord::find($id);
		if(is_null($inpatientrecord)){
            return $this->respond('not_found');
		}
		InpatientRecord::destroy($id);
        return $this->respond('removed',$inpatientrecord);
	}
}