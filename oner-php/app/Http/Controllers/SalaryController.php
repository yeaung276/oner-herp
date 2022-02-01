<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salary;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    // get all data
    public function all()
    {
        $salarys = Salary::all();
        return $this->respond('done', $salarys);
    }
    // retrieve single data
    public function get($id)
    {
        $salary = Salary::find($id);
        if (is_null($salary)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $salary);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'employee_id' => 'required',
            'basic_monthly_rate' => 'required',
            'overtime_hourly_rate' => 'required',
        ]);

        try {
            $salary = $request->all();
            $salary['created_user_id'] = Auth::user()->id;
            $salary['updated_user_id'] = 0;
            Salary::insert($salary);
            //return successful response
            return $this->respond('created', $salary);
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
            'basic_monthly_rate' => 'required',
            'overtime_hourly_rate' => 'required',
        ]);
        $salary = Salary::find($id);
        if (is_null($salary)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $salary->update($requestData);
        return $this->respond('done', $salary);
    }
    // remove single row
    public function remove($id)
    {
        $salary = Salary::find($id);
        if (is_null($salary)) {
            return $this->respond('not_found');
        }
        Salary::destroy($id);
        return $this->respond('removed', $salary);
    }
}
