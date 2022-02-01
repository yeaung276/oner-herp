<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\LabItem;

class LabItemController extends Controller
{
    // get all data
    public function all()
    {
        $labitems = LabItem::with('analyzers')->get();
        return $this->respond('done', $labitems);
    }
    // retrieve single data
    public function get($id)
    {
        $labitem = LabItem::with('analyzers')->find($id);
        if(is_null($labitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$labitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'part_number' => 'required',
           'product_name' => 'required'
        ]);

        try {
            $labitem = $request->all();

            LabItem::insert($labitem);
            //return successful response
            return $this->respond('created', $labitem);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'part_number' => 'required',
            'product_name' => 'required'
         ]);
        $labitem = LabItem::find($id);
        if(is_null($labitem)){
            return $this->respond('not_found');
        }
        $labitem->update($request->all());
        return $this->respond('done', $labitem);
    }
    // remove single row
    public function remove($id)
	{
		$labitem = LabItem::find($id);
		if(is_null($labitem)){
            return $this->respond('not_found');
		}
		LabItem::destroy($id);
        return $this->respond('removed',$labitem);

	}

    
}