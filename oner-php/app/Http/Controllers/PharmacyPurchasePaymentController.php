<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PharmacyPurchasePayment;
use Illuminate\Support\Facades\Auth;

class PharmacyPurchasePaymentController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacypurchasepayments = PharmacyPurchasePayment::all();
        return $this->respond('done', $pharmacypurchasepayments);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacypurchasepayment = PharmacyPurchasePayment::find($id);
        if (is_null($pharmacypurchasepayment)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $pharmacypurchasepayment);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'pharmacy_purchase_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        try {
            $pharmacypurchasepayment = $request->all();
            $pharmacypurchasepayment['created_user_id'] = Auth::user()->id;
            $pharmacypurchasepayment['updated_user_id'] = 0;
            PharmacyPurchasePayment::insert($pharmacypurchasepayment);
            //return successful response
            return $this->respond('created', $pharmacypurchasepayment);
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
            'pharmacy_purchase_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);
        $pharmacypurchasepayment = PharmacyPurchasePayment::find($id);
        if (is_null($pharmacypurchasepayment)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacypurchasepayment->update($requestData);
        return $this->respond('done', $pharmacypurchasepayment);
    }
    // remove single row
    public function remove($id)
    {
        $pharmacypurchasepayment = PharmacyPurchasePayment::find($id);
        if (is_null($pharmacypurchasepayment)) {
            return $this->respond('not_found');
        }
        PharmacyPurchasePayment::destroy($id);
        return $this->respond('removed', $pharmacypurchasepayment);
    }
}
