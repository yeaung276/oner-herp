<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvestigationRequestItem;

class InvestigationRequestItemController extends Controller
{
    // get all data
    public function all()
    {
        $investigationrequestitems = InvestigationRequestItem::with('item','request')->get();
        return $this->respond('done', $investigationrequestitems);
    }
    // retrieve single data
    public function get($id)
    {
        $investigationrequestitem = InvestigationRequestItem::with('item','request')->find($id);
        if (is_null($investigationrequestitem)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $investigationrequestitem);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'investigation_items_id' => 'required',
            'investigation_request_id' => 'required',
        ]);

        try {
            $investigationrequestitem = $request->all();
            $uploading = $this->uploadImage($request,"attachement","InvestigationRequestItems");
            if($uploading!=false){
                
                $investigationrequestitem['attachement'] = $uploading;
            }
            InvestigationRequestItem::insert($investigationrequestitem);
            //return successful response
            return $this->respond('created', $investigationrequestitem);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'investigation_items_id' => 'required',
            'investigation_request_id' => 'required',
        ]);
        $RequestData = $request->all();
        $investigationrequestitem = InvestigationRequestItem::find($id);
        if (is_null($investigationrequestitem)) {
            return $this->respond('not_found');
        }

        $uploading = $this->uploadImage($request,"attachement","InvestigationRequestItems");
        if($uploading!=false){
            $RequestData['attachement'] = $uploading;
        }

        $investigationrequestitem->update($RequestData);
        return $this->respond('done', $investigationrequestitem);
    }
    // remove single row
    public function remove($id)
    {
        $investigationrequestitem = InvestigationRequestItem::find($id);
        if (is_null($investigationrequestitem)) {
            return $this->respond('not_found');
        }
        InvestigationRequestItem::destroy($id);
        return $this->respond('removed', $investigationrequestitem);
    }
}
