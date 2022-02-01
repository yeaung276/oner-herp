<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // get all data
    public function all()
    {
        $payments = Payment::with('patient','bill')->get();
        return $this->respond('done', $payments);
    }
    // retrieve single data
    public function get($id)
    {
        $payment = Payment::with('patient','bill')->find($id);
        if (is_null($payment)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $payment);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'bill_id' => 'required',
            'collected_amount' => 'required',
            'patient_id' => 'required',
        ]);

        try {
            $payment = $request->all();
            $payment['created_user_id'] = Auth::user()->id;
            $payment['updated_user_id'] = 0;
            Payment::insert($payment);
            //return successful response
            return $this->respond('created', $payment);
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
            'bill_id' => 'required',
            'collected_amount' => 'required',
            'patient_id' => 'required',
        ]);
        $payment = Payment::find($id);
        if (is_null($payment)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $payment->update($requestData);
        return $this->respond('done', $payment);
    }
    // remove single row
    public function remove($id)
    {
        $payment = Payment::find($id);
        if (is_null($payment)) {
            return $this->respond('not_found');
        }
        Payment::destroy($id);
        return $this->respond('removed', $payment);
    }
}
