<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PharmacySaleReceipt;
use Illuminate\Support\Facades\Auth;

class PharmacySaleReceiptController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacysalereceipts = PharmacySaleReceipt::all();
        return $this->respond('done', $pharmacysalereceipts);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacysalereceipt = PharmacySaleReceipt::find($id);
        if (is_null($pharmacysalereceipt)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $pharmacysalereceipt);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'pharmacy_sale_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        try {
            $pharmacysalereceipt = $request->all();
            $pharmacysalereceipt['created_user_id'] = Auth::user()->id;
            $pharmacysalereceipt['updated_user_id'] = 0;
            PharmacySaleReceipt::insert($pharmacysalereceipt);
            //return successful response
            return $this->respond('created', $pharmacysalereceipt);
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
            'pharmacy_sale_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);
        $pharmacysalereceipt = PharmacySaleReceipt::find($id);
        if (is_null($pharmacysalereceipt)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacysalereceipt->update($requestData);
        return $this->respond('done', $pharmacysalereceipt);
    }
    // remove single row
    public function remove($id)
    {
        $pharmacysalereceipt = PharmacySaleReceipt::find($id);
        if (is_null($pharmacysalereceipt)) {
            return $this->respond('not_found');
        }
        PharmacySaleReceipt::destroy($id);
        return $this->respond('removed', $pharmacysalereceipt);
    }
}
