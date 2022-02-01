<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PharmacySaleItem;
use Illuminate\Support\Facades\Auth;

class PharmacySaleItemController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacysaleitems = PharmacySaleItem::all();
        return $this->respond('done', $pharmacysaleitems);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacysaleitem = PharmacySaleItem::find($id);
        if (is_null($pharmacysaleitem)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $pharmacysaleitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'pharmacy_sale_id' => 'required',
            'pharmacy_item_id' => 'required',
            'quantity' => 'required',
            'sale_price' => 'required',
            'amount' => 'required',
        ]);

        try {
            $pharmacysaleitem = $request->all();
            $pharmacysaleitem['created_user_id'] = Auth::user()->id;
            $pharmacysaleitem['updated_user_id'] = 0;
            $ID = PharmacySaleItem::insertGetId($pharmacysaleitem);
            $pharmacysaleitem['id'] =$ID;
            //return successful response
            return $this->respond('created', $pharmacysaleitem);
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
            'pharmacy_item_id' => 'required',
            'quantity' => 'required',
            'sale_price' => 'required',
            'amount' => 'required',
        ]);
        $pharmacysaleitem = PharmacySaleItem::find($id);
        if (is_null($pharmacysaleitem)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacysaleitem->update($requestData);
        return $this->respond('done', $pharmacysaleitem);
    }
    // remove single row
    public function remove($id)
    {
        $pharmacysaleitem = PharmacySaleItem::find($id);
        if (is_null($pharmacysaleitem)) {
            return $this->respond('not_found');
        }
        PharmacySaleItem::destroy($id);
        return $this->respond('removed', $pharmacysaleitem);
    }
}
