<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ServiceItem;

class ServiceItemController extends Controller
{
    // get all data
    public function all()
    {
        $serviceitems = ServiceItem::all();
        return $this->respond('done', $serviceitems);
    }
    // retrieve single data
    public function get($id)
    {
        $serviceitem = ServiceItem::find($id);
        if(is_null($serviceitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$serviceitem);
        
        
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'service_type' => 'required',
            'relation_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'charge' => 'required',
        ]);

        try {
            $serviceitem = $request->all();
            ServiceItem::insert($serviceitem);
            //return successful response
            return $this->respond('created', $serviceitem);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'service_type' => 'required',
            'relation_id' => 'required',
         ]);
        $serviceitem = ServiceItem::find($id);
        if(is_null($serviceitem)){
            return $this->respond('not_found');
        }
        $serviceitem->update($request->all());
        return $this->respond('done', $serviceitem);
    }
    // remove single row
    public function remove($id)
	{
		$serviceitem = ServiceItem::find($id);
		if(is_null($serviceitem)){
            return $this->respond('not_found');
		}
		ServiceItem::destroy($id);
        return $this->respond('removed',$serviceitem);

	}

    
}