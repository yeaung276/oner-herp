<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PatientServiceUsedRecord;
use App\ServiceItem;
use App\BillItem;
use Illuminate\Support\Facades\Auth;

class PatientServiceUsedRecordController extends Controller
{
    // get all data
    public function all(Request $request)
    {
        
        if(!empty($request->get('page'))){
            $psurs = PatientServiceUsedRecord::with('patient')->orderBy('id','desc')->paginate();
        }else{
            $psurs = PatientServiceUsedRecord::with('patient')->get();
        }
        
        return $this->respond('done', $psurs);
    }
    // retrieve single data
    public function get($id)
    {
        $psur = PatientServiceUsedRecord::with('patient')->find($id);
        if (is_null($psur)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $psur);
    }
    // get by service id
    public function getByServiceId($id){
        $bill_items = BillItem::join('patient_service_used_records','patient_service_used_records.id','=','bill_items.patient_service_used_id')->where('service_item_id',$id)->get();
        return $this->respond('done',$bill_items);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'patient_id' => 'required',
        ]);

        try {
            $psur = $request->all();
            $service_item = ServiceItem::find($request['service_item_id']);
            $psur['service_name'] = $service_item['name'];
            $psur['created_user_id'] = Auth::user()->id;
            $psur['updated_user_id'] = 0;
            PatientServiceUsedRecord::insert($psur);
            //return successful response
            return $this->respond('created', $psur);
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
        ]);
        $psur = PatientServiceUsedRecord::find($id);
        if (is_null($psur)) {
            return $this->respond('not_found');
	
	}
	if ($psur['status']=='close'){
	    return $this->respond('close item');
	}
        $requestData['updated_user_id'] = Auth::user()->id;
        $psur->update($requestData);
        return $this->respond('done', $psur);
    }
    // remove single row
    public function remove($id)
    {
        $psur = PatientServiceUsedRecord::find($id);
        if (is_null($psur)) {
            return $this->respond('not_found');
        }
        PatientServiceUsedRecord::destroy($id);
        return $this->respond('removed', $psur);
    }
    public function getallopen($pid){
        $psurs = PatientServiceUsedRecord::with('patient','service_item')->where('patient_id',$pid)->where('status','open')->get();
        return $this->respond('done', $psurs);
    }    
    public function getOpenItems(){
        $psurs = PatientServiceUsedRecord::with('patient','service_item')->where('status','open')->get();
        return $this->respond('done',$psurs);
    }
    // get with date filter
    public function getWithDates(Request $request){
         //validate incoming request 
         $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        try {
            $psur = $request->all();
            $from = $psur['from'];
            $to = $psur['to'];
            $results = PatientServiceUsedRecord::with('patient', 'service_item')->whereBetween('created_time', [$from, $to])->get();
            //return successful response
            return $this->respond('done', $results);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
}
