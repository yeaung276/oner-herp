<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CtTestOrderItem;
use Illuminate\Support\Facades\Auth;

class CtTestOrderItemController extends Controller
{
    // get all data
    public function all()
    {
        $ct_test_order_items = CtTestOrderItem::with('patient','doctor')->get();
        return $this->respond('done', $ct_test_order_items);
    }
    // retrieve single data
    public function get($id)
    {
        $ct_test_order_item = CtTestOrderItem::with('patient','doctor')->find($id);
        if(is_null($ct_test_order_item)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$ct_test_order_item);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'ct_test_order_id' => 'required',   
        ]);

        try {
            $ct_test_order_item = $request->all();

            $request_uploading = $this->uploadImage($request,"result","CtTestOrderItem");
            if($request_uploading!=false){                
                $ct_test_order_item['result'] = $request_uploading;
            }
            $ct_test_order_item['created_user_id'] = Auth::user()->id;
            $ct_test_order_item['updated_user_id'] = 0;
            CtTestOrderItem::insert($ct_test_order_item);
            //return successful response
            return $this->respond('created', $ct_test_order_item);
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
            'ct_test_order_id' => 'required',
        ]);
        $request_uploading = $this->uploadImage($request,"result","CtTestOrderItem");
        if($request_uploading!=false){                
            $requestData['result'] = $request_uploading;
        }
        $ct_test_order_item = CtTestOrderItem::find($id);
        if(is_null($ct_test_order_item)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $ct_test_order_item->update($requestData);
        return $this->respond('done', $ct_test_order_item);
    }
    // remove single row
    public function remove($id)
	{
		$ct_test_order_item = CtTestOrderItem::find($id);
		if(is_null($ct_test_order_item)){
            return $this->respond('not_found');
		}
		CtTestOrderItem::destroy($id);
        return $this->respond('removed',$ct_test_order_item);
	}
    public function getbypid($pid){
        $ct_test_order_items = CtTestOrderItem::where('patient_id',$pid)->get();
        return $this->respond('done', $ct_test_order_items);
    }
}