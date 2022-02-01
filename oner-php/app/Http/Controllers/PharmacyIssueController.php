<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\PharmacyIssue;
use Illuminate\Support\Facades\Auth;

class PharmacyIssueController extends Controller
{
    // get all data
    public function all()
    {
        $pharmacyissues = PharmacyIssue::all();
        return $this->respond('done', $pharmacyissues);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacyissue = PharmacyIssue::with('detail.pharmacy_item')->find($id);
        if(is_null($pharmacyissue)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$pharmacyissue);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'date' => 'required',
           'issue_to' => 'required',
           'total_amount' => 'required',
        ]);

        try {
            $pharmacyissue = $request->all();
            $pharmacyissue['created_user_id'] = Auth::user()->id;
            $pharmacyissue['updated_user_id'] = 0;
            $pharmacyIssueId = PharmacyIssue::insertGetId($pharmacyissue);
            $pharmacyissue['id'] = $pharmacyIssueId;
            //return successful response
            return $this->respond('created', $pharmacyissue);
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
            'date' => 'required',
            'issue_to' => 'required',
            'total_amount' => 'required',
         ]);
        $pharmacyissue = PharmacyIssue::find($id);
        if(is_null($pharmacyissue)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $pharmacyissue->update($requestData);
        return $this->respond('done', $pharmacyissue);
    }
    // remove single row
    public function remove($id)
	{
		$pharmacyissue = PharmacyIssue::find($id);
		if(is_null($pharmacyissue)){
            return $this->respond('not_found');
		}
		PharmacyIssue::destroy($id);
        return $this->respond('removed',$pharmacyissue);
	}
}