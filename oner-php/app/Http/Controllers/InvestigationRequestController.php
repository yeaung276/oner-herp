<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvestigationRequest;
use App\InvestigationRequestItem;

class InvestigationRequestController extends Controller
{
    // get all data
    public function all()
    {
        $investigationrequests = InvestigationRequest::with('patient','requested_doctor.employee','assigned_doctor.employee','request_items.item.ranges','request_items.item.category')->get();
        return $this->respond('done', $investigationrequests);
    }
    // retrieve single data
    public function get($id)
    {
        $investigationrequest = InvestigationRequest::with('patient','requested_doctor.employee','assigned_doctor.employee','request_items.item.ranges','request_items.item.category')->find($id);
        if (is_null($investigationrequest)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $investigationrequest);
    }
    public function getByDoctor($did){
        $investigationrequest = InvestigationRequest::with('patient','requested_doctor.employee','request_items.item.service_item')->where('requested_doctor_id','=',$did)->get();
        return $this->respond('done', $investigationrequest);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'patient_id' => 'required',
            'investigation_report_id' => 'required',
            'cost' => 'required',
            'status' => 'required',
        ]);
        
        try {
            $irequest = $request->all();
            $irdetail = $irequest['items'];
            unset($irequest['items']);

            $irequestID = InvestigationRequest::insertGetId($irequest);

            $irequestdetail = [];
            $saleitemAmount = 0;
            foreach ($irdetail as $value) {
                $value['investigation_request_id'] = $irequestID;
                $value['investigation_items_id'] = $value['investigation_items_id'];
                
                $irequestdetail[] = $value;
            }
            InvestigationRequestItem::insert($irequestdetail);

            return $this->respond('created', $irequest);
            
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
            'investigation_report_id' => 'required',
            'cost' => 'required',
            'status' => 'required',
        ]);
        $investigationrequest = InvestigationRequest::find($id);
        if (is_null($investigationrequest)) {
            return $this->respond('not_found');
        }
        $investigationrequest->update($request->all());
        return $this->respond('done', $investigationrequest);
    }
    // remove single row
    public function remove($id)
    {
        $investigationrequest = InvestigationRequest::find($id);
        if (is_null($investigationrequest)) {
            return $this->respond('not_found');
        }
        InvestigationRequest::destroy($id);
        return $this->respond('removed', $investigationrequest);
    }
    public function getbypid($pid){
        $investigationrequests = InvestigationRequest::with('patient','requested_doctor.employee','assigned_doctor.employee','request_items.item.ranges','request_items.item.category')
        ->where('patient_id',$pid)
        ->get();
        return $this->respond('done', $investigationrequests);
    }
}
