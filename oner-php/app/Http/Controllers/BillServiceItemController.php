<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Bill;
use App\BillReceipt;
use App\BillServiceItem;
use Illuminate\Support\Facades\Auth;
class BillServiceItemController extends Controller
{
    // get all data
    public function all()
    {
        $billserviceitems = BillServiceItem::all();
        return $this->respond('done', $billserviceitems);
    }
    // retrieve single data
    public function get($id)
    {
        $billserviceitem = BillServiceItem::find($id);
        if(is_null($billserviceitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$billserviceitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'bill_id' => 'required',
            'service_item_id' => 'required',
            'charge' => 'required',
            'charge_type' => 'required',
        ]);

        try {
            $billserviceitem = $request->all();
            
            BillServiceItem::insert($billserviceitem);
            //return successful response
            return $this->respond('created', $billserviceitem);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'bill_id' => 'required',
            'service_item_id' => 'required',
            'charge' => 'required',
            'charge_type' => 'required',
         ]);
        $billserviceitem = BillServiceItem::find($id);
        if(is_null($billserviceitem)){
            return $this->respond('not_found');
        }
        
        $billserviceitem->update($request->all());
        return $this->respond('done', $billserviceitem);
    }
    // remove single row
    public function remove($id)
	{
		$billserviceitem = BillServiceItem::find($id);
		if(is_null($billserviceitem)){
            return $this->respond('not_found');
		}
		BillServiceItem::destroy($id);
        return $this->respond('removed',$billserviceitem);

	}

    
}