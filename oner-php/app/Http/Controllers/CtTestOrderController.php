<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CtTestOrder;
use App\CtTestOrderItem;
use Illuminate\Support\Facades\Auth;

class CtTestOrderController extends Controller
{
    // get all data
    public function all()
    {
        $ct_test_orders = CtTestOrder::with('patient','doctor.employee',
        'ctto_items.investigation_item',
        'ctto_items.investigation_item.category',
        'ctto_items.investigation_item.department',
        'ctto_items.investigation_item.ranges',
        'ctto_items.investigation_item.service_item')->get();
        return $this->respond('done', $ct_test_orders);
    }
    public function getOpen(){
        $ct_test_orders = CtTestOrder::with('patient','doctor.employee',
        'ctto_items.investigation_item',
        'ctto_items.investigation_item.category',
        'ctto_items.investigation_item.department',
        'ctto_items.investigation_item.ranges',
        'ctto_items.investigation_item.service_item')->where('status','confirm')->orWhere('status','ipd')->get();
        return $this->respond('done', $ct_test_orders);
    }
    public function getComplete(Request $request){
        $ct_test_orders = CtTestOrder::with('patient','doctor.employee',
        'ctto_items.investigation_item',
        'ctto_items.investigation_item.category',
        'ctto_items.investigation_item.department',
        'ctto_items.investigation_item.ranges',
        'ctto_items.investigation_item.service_item')->where('status','complete')->orWhere('status','cancelled')->get();
        return $this->respond('done', $ct_test_orders);

    }
    // retrieve single data
    public function get($id)
    {
        $ct_test_order = CtTestOrder::with('patient','doctor',
        'ctto_items.investigation_item',
        'ctto_items.investigation_item.category',
        'ctto_items.investigation_item.department',
        'ctto_items.investigation_item.ranges',
        'ctto_items.investigation_item.service_item')->find($id);
        if(is_null($ct_test_order)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$ct_test_order);
    }
    public function getByDoctor($did){
        $ct_test_order = CtTestOrder::with('patient','doctor','ctto_items.investigation_item.service_item')->where('doctor_id','=',$did)->get();
        return $this->respond('done',$ct_test_order);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'patient_id' => 'required',   
        ]);

        try {
            $ct_test_order = $request->all();
            $investigation_items = $ct_test_order['items'];
            unset($ct_test_order['items']);
            $request_form_uploading = $this->uploadImage($request,"request_form","CtTestOrder");
            if($request_form_uploading!=false){                
                $ct_test_order['request_form'] = $request_form_uploading;
            }

            $consent_form_uploading = $this->uploadImage($request,"consent_form","CtTestOrder");
            if($consent_form_uploading!=false){
                $ct_test_order['consent_form'] = $consent_form_uploading;
            }

            $ct_test_order['created_user_id'] = Auth::user()->id;
            $ct_test_order['updated_user_id'] = 0;

            $CtTestOrderID = CtTestOrder::insertGetId($ct_test_order);

            $investigation_items_details = [];
            foreach ($investigation_items as $value) {
                $value['ct_test_order_id'] = $CtTestOrderID;
                $investigation_item_uploading = $this->uploadImage($request,"consent_form","CtTestOrder_IIResult");
                if($investigation_item_uploading!=false){
                    $value['result'] = $investigation_item_uploading;
                }
                $value['created_user_id'] = Auth::user()->id;
                $value['updated_user_id'] = 0;
                $investigation_items_details[] = $value;
            }
            CtTestOrderItem::insert($investigation_items_details);
            //return successful response
            return $this->respond('created', $ct_test_order);
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
        $ct_test_order = CtTestOrder::find($id);
        if(is_null($ct_test_order)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $ct_test_order->update($requestData);
        return $this->respond('done', $ct_test_order);
    }
    // remove single row
    public function remove($id)
	{
		$ct_test_order = CtTestOrder::find($id);
		if(is_null($ct_test_order)){
            return $this->respond('not_found');
		}
		CtTestOrder::destroy($id);
        return $this->respond('removed',$ct_test_order);
	}
    public function getbypid($pid){
        $ct_test_orders = CtTestOrder::where('patient_id',$pid)->get();
        return $this->respond('done', $ct_test_orders);
    }
}