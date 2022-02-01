<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\BillAdjustment;
use Illuminate\Support\Facades\Auth;
class BillAdjustmentController extends Controller
{
    // get all data
    public function all()
    {
        $billadjustments = BillAdjustment::all();
        return $this->respond('done', $billadjustments);
    }
    // retrieve single data
    public function get($id)
    {
        $billadjustment = BillAdjustment::find($id);
        if(is_null($billadjustment)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$billadjustment);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'counter' => 'required',
            'payment_id' => 'required',
        ]);

        try {
            $billadjustment = $request->all();
            $billadjustment['created_user_id'] = Auth::user()->id;
            $billadjustment['updated_user_id'] = 0;
            BillAdjustment::insert($billadjustment);
            //return successful response
            return $this->respond('created', $billadjustment);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'counter' => 'required',
            'payment_id' => 'required',
         ]);
        $billadjustment = BillAdjustment::find($id);
        if(is_null($billadjustment)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $billadjustment->update($request->all());
        return $this->respond('done', $billadjustment);
    }
    // remove single row
    public function remove($id)
	{
		$billadjustment = BillAdjustment::find($id);
		if(is_null($billadjustment)){
            return $this->respond('not_found');
		}
		BillAdjustment::destroy($id);
        return $this->respond('removed',$billadjustment);

	}

    
}