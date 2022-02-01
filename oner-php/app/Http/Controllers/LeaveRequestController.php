<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    // get all data
    public function all()
    {
        $leaverequests = LeaveRequest::all();
        return $this->respond('done', $leaverequests);
    }
    // retrieve single data
    public function get($id)
    {
        $leaverequest = LeaveRequest::find($id);
        if (is_null($leaverequest)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $leaverequest);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'leave_date' => 'required',
            'comment' => 'required',
            'day_period' => 'required',
        ]);

        try {
            $leaverequest = $request->all();
            $leaverequest['created_user_id'] = Auth::user()->id;
            $leaverequest['updated_user_id'] = 0;
            LeaveRequest::insert($leaverequest);
            //return successful response
            return $this->respond('created', $leaverequest);
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
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'leave_date' => 'required',
            'comment' => 'required',
            'day_period' => 'required',
        ]);
        $leaverequest = LeaveRequest::find($id);
        if (is_null($leaverequest)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $leaverequest->update($requestData);
        return $this->respond('done', $leaverequest);
    }
    // remove single row
    public function remove($id)
    {
        $leaverequest = LeaveRequest::find($id);
        if (is_null($leaverequest)) {
            return $this->respond('not_found');
        }
        LeaveRequest::destroy($id);
        return $this->respond('removed', $leaverequest);
    }
}
