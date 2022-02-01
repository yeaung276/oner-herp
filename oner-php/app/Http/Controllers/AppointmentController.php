<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Appointment;
use App\Doctor;
use App\OPDRoom;
use App\Patient;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // get all data
    public function all()
    {
        $appointments = Appointment::with('patient','doctor.employee.department','doctor.employee.position','opd')->get();
        $patients = Patient::all();
        $doctors = Doctor::with('employee.department','employee.position')->get();
        $opds = OPDRoom::all();
        $respData['appointments'] = $appointments;
        $respData['patients'] = $patients;
        $respData['doctors'] = $doctors;
        $respData['opds'] = $opds;
        return $this->respond('done', $respData);
    }
    // retrieve single data
    public function get($id)
    {
        $appointment = Appointment::find($id);
        if(is_null($appointment)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$appointment);
    }
    public function getByDate($date){
        $appointments = Appointment::with('patient','doctor.employee.department','doctor.employee.position','opd')->whereDate('appointment_time',$date)->get();
        return $this->respond('done',$appointments);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'opd_room_id' => 'required',
            'status' => 'required',
            // 'appointment_type' => 'required',
            // 'source' => 'required',
        ]);

        try {
            $appointment = $request->all();
            $_appointments = Appointment::where('doctor_id',$request->get('doctor_id'))->whereBetween('created_time',[date('y-m-d').' 00:00:00%',date('y-m-d').' 23:59:59%'])->count();
            
            $appointment['queue_ticket_number'] = str_pad($request->get('doctor_id'), 4, '0', STR_PAD_LEFT).'-'.str_pad($_appointments+1, 4, '0', STR_PAD_LEFT).'-'.date('dmy');
            $appointment['created_user_id'] = Auth::user()->id;
            $appointment['updated_user_id'] = 0;
            Appointment::insert($appointment);
            //return successful response
            return $this->respond('created', $appointment);
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
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'opd_room_id' => 'required',
            'status' => 'required',
            // 'appointment_type' => 'required',
            // 'source' => 'required',
        ]);
        
        $appointment = Appointment::find($id);
        if(is_null($appointment)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $appointment->update($requestData);
        return $this->respond('done', $appointment);
    }
    // remove single row
    public function remove($id)
	{
		$appointment = Appointment::find($id);
		if(is_null($appointment)){
            return $this->respond('not_found');
		}
		Appointment::destroy($id);
        return $this->respond('removed',$appointment);
    }
    
}