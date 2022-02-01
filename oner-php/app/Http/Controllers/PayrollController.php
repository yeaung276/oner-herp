<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payroll;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    // get all data
    public function all()
    {
        $payrolls = Payroll::all();
        return $this->respond('done', $payrolls);
    }
    // retrieve single data
    public function get($id)
    {
        $payroll = Payroll::find($id);
        if (is_null($payroll)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $payroll);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'employee_id' => 'required',
            'basic_salary' => 'required',
            'overtime_fee' => 'required',
            'bonus' => 'required',
            'tax' => 'required',
            'deduction' => 'required',
            'month' => 'required',
            'year' => 'required',
            'notes' => 'required',
        ]);

        try {
            $payroll = $request->all();
            $payroll['created_user_id'] = Auth::user()->id;
            $payroll['updated_user_id'] = 0;
            Payroll::insert($payroll);
            //return successful response
            return $this->respond('created', $payroll);
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
            'basic_salary' => 'required',
            'overtime_fee' => 'required',
            'bonus' => 'required',
            'tax' => 'required',
            'deduction' => 'required',
            'month' => 'required',
            'year' => 'required',
            'notes' => 'required',
        ]);
        $payroll = Payroll::find($id);
        if (is_null($payroll)) {
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $payroll->update($requestData);
        return $this->respond('done', $payroll);
    }
    // remove single row
    public function remove($id)
    {
        $payroll = Payroll::find($id);
        if (is_null($payroll)) {
            return $this->respond('not_found');
        }
        Payroll::destroy($id);
        return $this->respond('removed', $payroll);
    }
}
