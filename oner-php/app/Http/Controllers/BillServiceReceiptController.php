<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Bill;
use App\BillReceipt;
use App\BillServiceItem;
use Illuminate\Support\Facades\Auth;
class BillServiceReceiptController extends Controller
{
    // get all data
    public function all()
    {
        $billservicereceipts = BillReceipt::all();
        return $this->respond('done', $billservicereceipts);
    }
    // retrieve single data
    public function get($id)
    {
        $billservicereceipt = BillReceipt::find($id);
        if(is_null($billservicereceipt)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$billservicereceipt);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'bill_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        try {
            $billservicereceipt = $request->all();
            $billservicereceipt['created_user_id'] = Auth::user()->id;
            $billservicereceipt['updated_user_id'] = 0;
            BillReceipt::insert($billservicereceipt);
            //return successful response
            return $this->respond('created', $billservicereceipt);
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
            'date' => 'required',
            'amount' => 'required',
            'status' => 'required',
         ]);
        $billservicereceipt = BillReceipt::find($id);
        if(is_null($billservicereceipt)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $billservicereceipt->update($request->all());
        return $this->respond('done', $billservicereceipt);
    }
    // remove single row
    public function remove($id)
	{
		$billservicereceipt = BillReceipt::find($id);
		if(is_null($billservicereceipt)){
            return $this->respond('not_found');
		}
		BillReceipt::destroy($id);
        return $this->respond('removed',$billservicereceipt);

	}

    
}