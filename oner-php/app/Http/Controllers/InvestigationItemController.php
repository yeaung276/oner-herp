<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InvestigationItem;
use App\InvestigationItemRange;

class InvestigationItemController extends Controller
{
    // get all data
    public function all()
    {
        $investigationitems = InvestigationItem::with('category','department','ranges','service_item')->get();
        return $this->respond('done', $investigationitems);
    }
    // retrieve single data
    public function get($id)
    {
        $investigationitem = InvestigationItem::with('category','department','ranges','service_item')->find($id);
        if(is_null($investigationitem)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$investigationitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'investigation_category_id' => 'required',
           'investigation_department_id' => 'required',
           'investigation_item_name' => 'required',
        ]);

        try {
            $investigationitem = $request->all();
            $ranges = $investigationitem['ranges'];
            unset($investigationitem['ranges']);

            $iiID = InvestigationItem::insertGetId($investigationitem);
            
            $rangeDetail = [];
            
            foreach ($ranges as $value) {
                $rangeDetail[] = [
                    'investigation_item_id' => $iiID,
                    'marker' => $value['marker'],
                    'upper_limit' => $value['upper_limit'],
                    'lower_limit' => $value['lower_limit'],
                ];

            }
            InvestigationItemRange::insert($rangeDetail);
            //return successful response
            return $this->respond('created', $investigationitem);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'investigation_category_id' => 'required',
            'investigation_department_id' => 'required',
            'investigation_item_name' => 'required'
         ]);
        $investigationitem = InvestigationItem::find($id);
        if(is_null($investigationitem)){
            return $this->respond('not_found');
        }
        $iitem = $request->all();
        $ranges = $iitem['ranges'];
        unset($iitem['ranges']);

        $investigationitem->update($iitem);
        return $this->respond('done', $investigationitem);
    }
    // remove single row
    public function remove($id)
	{
		$investigationitem = InvestigationItem::find($id);
		if(is_null($investigationitem)){
            return $this->respond('not_found');
		}
		InvestigationItem::destroy($id);
        return $this->respond('removed',$investigationitem);

	}

    
}