<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PharmacyPurchaseItem;
use Illuminate\Support\Facades\Auth;

class PharmacyPurchaseItemController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacypurchaseitems = PharmacyPurchaseItem::all();
        return $this->respond('done', $pharmacypurchaseitems);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacypurchaseitem = PharmacyPurchaseItem::find($id);
        if (is_null($pharmacypurchaseitem)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $pharmacypurchaseitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'pharmacy_purchase_id' => 'required',
            'pharmacy_item_id' => 'required',
            'quantity' => 'required',
            'purchase_price' => 'required',
            'amount' => 'required',
        ]);

        try {
            $pharmacypurchaseitem = $request->all();
            $pharmacypurchaseitem['created_user_id'] = Auth::user()->id;
            $pharmacypurchaseitem['updated_user_id'] = 0;
            PharmacyPurchaseItem::insert($pharmacypurchaseitem);
            //return successful response
            return $this->respond('created', $pharmacypurchaseitem);
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
            'pharmacy_item_id' => 'required',
            'quantity' => 'required',
            'purchase_price' => 'required',
            'amount' => 'required',
        ]);
        $pharmacypurchaseitem = PharmacyPurchaseItem::find($id);
        if (is_null($pharmacypurchaseitem)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacypurchaseitem->update($requestData);
        return $this->respond('done', $pharmacypurchaseitem);
    }
    // remove single row
    public function remove($id)
    {
        $pharmacypurchaseitem = PharmacyPurchaseItem::find($id);
        if (is_null($pharmacypurchaseitem)) {
            return $this->respond('not_found');
        }
        PharmacyPurchaseItem::destroy($id);
        return $this->respond('removed', $pharmacypurchaseitem);
    }
}
