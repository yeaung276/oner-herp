<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveType;
use Illuminate\Support\Facades\Auth;

class LeaveTypeController extends Controller
{
    // get all data
    public function all()
    {
        $leavetypes = LeaveType::all();
        return $this->respond('done', $leavetypes);
    }
    // retrieve single data
    public function get($id)
    {
        $leavetype = LeaveType::find($id);
        if (is_null($leavetype)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $leavetype);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required',
            'allowance_days_per_year' => 'required',
        ]);

        try {
            $leavetype = $request->all();
            // $leavetype['created_user_id'] = Auth::user()->id;
            // $leavetype['updated_user_id'] = 0;
            LeaveType::insert($leavetype);
            //return successful response
            return $this->respond('created', $leavetype);
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
            'name' => 'required',
            'allowance_days_per_year' => 'required',
        ]);
        $leavetype = LeaveType::find($id);
        if (is_null($leavetype)) {
            return $this->respond('not_found');
        }
        // $requestData['updated_user_id'] = Auth::user()->id;
        $leavetype->update($requestData);
        return $this->respond('done', $leavetype);
    }
    // remove single row
    public function remove($id)
    {
        $leavetype = LeaveType::find($id);
        if (is_null($leavetype)) {
            return $this->respond('not_found');
        }
        LeaveType::destroy($id);
        return $this->respond('removed', $leavetype);
    }
}
