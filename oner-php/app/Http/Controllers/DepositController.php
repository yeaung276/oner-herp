<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Deposit;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    // get all data
    public function all()
    {
        $deposits = Deposit::with('patient')->get();
        return $this->respond('done', $deposits);
    }
    // retrieve single data
    public function get($id)
    {
        $deposit = Deposit::with('patient')->find($id);
        if (is_null($deposit)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $deposit);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'collected_amount' => 'required',
            'patient_id' => 'required',
        ]);

        try {
            $deposit = $request->all();
            $deposit['created_user_id'] = Auth::user()->id;
            $deposit['updated_user_id'] = 0;
            Deposit::insert($deposit);
            //return successful response
            return $this->respond('created', $deposit);
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
            'collected_amount' => 'required',
            'patient_id' => 'required',
        ]);
        $deposit = Deposit::find($id);
        if (is_null($deposit)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $deposit->update($requestData);
        return $this->respond('done', $deposit);
    }
    // remove single row
    public function remove($id)
    {
        $deposit = Deposit::find($id);
        if (is_null($deposit)) {
            return $this->respond('not_found');
        }
        Deposit::destroy($id);
        return $this->respond('removed', $deposit);
    }
    public function getallopen($pid){
        $deposits = Deposit::with('patient')->where('patient_id',$pid)->where('status','open')->get();
        return $this->respond('done', $deposits);
    }
}
