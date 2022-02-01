<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // get all data
    public function all()
    {
        $attendances = Attendance::all();
        return $this->respond('done', $attendances);
    }
    // retrieve single data
    public function get($id)
    {
        $attendance = Attendance::find($id);
        if (is_null($attendance)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $attendance);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'employee_id' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        try {
            $attendance = $request->all();
            $attendance['created_user_id'] = Auth::user()->id;
            $attendance['updated_user_id'] = 0;
            Attendance::insert($attendance);
            //return successful response
            return $this->respond('created', $attendance);
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
            'time_in' => 'required',
            'time_out' => 'required',
        ]);
        $attendance = Attendance::find($id);
        if (is_null($attendance)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $attendance->update($requestData);
        return $this->respond('done', $attendance);
    }
    // remove single row
    public function remove($id)
    {
        $attendance = Attendance::find($id);
        if (is_null($attendance)) {
            return $this->respond('not_found');
        }
        Attendance::destroy($id);
        return $this->respond('removed', $attendance);
    }
}
