<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\GeneralItem;

class GeneralItemController extends Controller
{
    // get all data
    public function all()
    {
        $generalitems = GeneralItem::get();
        return $this->respond('done', $generalitems);
    }
    // retrieve single data
    public function get($id)
    {
        $generalitem = GeneralItem::find($id);
        if(is_null($generalitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$generalitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $generalitem = $request->all();

            GeneralItem::insert($generalitem);
            //return successful response
            return $this->respond('created', $generalitem);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
         ]);
        $generalitem = GeneralItem::find($id);
        if(is_null($generalitem)){
            return $this->respond('not_found');
        }
        $generalitem->update($request->all());
        return $this->respond('done', $generalitem);
    }
    // remove single row
    public function remove($id)
	{
		$generalitem = GeneralItem::find($id);
		if(is_null($generalitem)){
            return $this->respond('not_found');
		}
		GeneralItem::destroy($id);
        return $this->respond('removed',$generalitem);

	}

    
}