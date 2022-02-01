<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InvestigationItemRange;

class InvestigationItemRangeController extends Controller
{
    // get all data
    public function all()
    {
        $investigationitemranges = InvestigationItemRange::get();
        return $this->respond('done', $investigationitemranges);
    }
    // retrieve single data
    public function get($id)
    {
        $investigationitemrange = InvestigationItemRange::find($id);
        if(is_null($investigationitemrange)){
            return $this->respond('not_found');
        }   
        return $this->respond('done',$investigationitemrange);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
        //    'name' => 'required',
        //    'status' => 'required'
                'marker'=>'required',
                'lower_limit'=>'required',
                'upper_limit'=>'required',
                'investigation_item_id'=>'required',
        ]);

        try {
            $investigationitemrange = $request->all();

            $result = InvestigationItemRange::insertGetId($investigationitemrange);
            //return successful response
            $investigationitemrange['id'] = $result;
            return $this->respond('created', $investigationitemrange);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'marker'=>'required',
            'lower_limit'=>'required',
            'upper_limit'=>'required',
            'investigation_item_id'=>'required',
         ]);
        $investigationitemrange = InvestigationItemRange::find($id);
        if(is_null($investigationitemrange)){
            return $this->respond('not_found');
        }
        $investigationitemrange->update($request->all());
        return $this->respond('done', $investigationitemrange);
    }
    // remove single row
    public function remove($id)
	{
		$investigationitemrange = InvestigationItemRange::find($id);
		if(is_null($investigationitemrange)){
            return $this->respond('not_found');
		}
		InvestigationItemRange::destroy($id);
        return $this->respond('removed',$investigationitemrange);

	}

    
}