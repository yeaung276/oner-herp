<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Prescription;
use App\PrescriptionItem;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    // get all data
    public function all()
    {
        $prescriptions = Prescription::with('patient','doctor.employee')->get();
        return $this->respond('done', $prescriptions);
    }
    // retrieve single data
    public function get($id)
    {
        $prescription = Prescription::with('patient','doctor.employee','prescription_item.pharmacy_item')->find($id);
        if(is_null($prescription)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$prescription);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        // $this->validate($request, [
        //    'medical_record_id' => 'required',
        //    'pharmacy_item_id' => 'required',
        //    'quantity' => 'required',   
        // ]);
        $this->validate($request, [
            // 'medical_record_id' => 'required',
            'patient_id' => 'required',
            'doctor_id' => 'required',
        ]);


        try {
            $prescription = $request->all();
            $predetail = $prescription['items'];
            unset($prescription['items']);
            $prescription['created_user_id'] = Auth::user()->id;
            $prescription['updated_user_id'] = 0;
            
            $PrescriptionID = Prescription::insertGetId($prescription);

            $prescriptiondetail = [];
            foreach ($predetail as $value) {
                $value['prescription_id'] = $PrescriptionID;
                $prescriptiondetail[] = $value;
            }
            PrescriptionItem::insert($prescriptiondetail);
            
            //return successful response
            return $this->respond('created', $prescription);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $requestData = $request->all();
        // $this->validate($request, [
        //     'medical_record_id' => 'required',
        //     'pharmacy_item_id' => 'required',
        //     'quantity' => 'required',
        //  ]);
        $this->validate($request, [
            // 'medical_record_id' => 'required',
            'patient_id' => 'required',
            'doctor_id' => 'required',
        ]);

        $prescription = Prescription::find($id);
        if(is_null($prescription)){
            return $this->respond('not_found');
        }
        $requestData['updated_user_id'] = Auth::user()->id;
        $prescription->update($requestData);
        return $this->respond('done', $prescription);
    }
    // remove single row
    public function remove($id)
	{
		$prescription = Prescription::find($id);
		if(is_null($prescription)){
            return $this->respond('not_found');
		}
		Prescription::destroy($id);
        return $this->respond('removed',$prescription);
	}
    public function getbypid($pid){
        $prescriptions = Prescription::with('patient','doctor.employee')->where('patient_id',$pid)->get();
        return $this->respond('done', $prescriptions);
    }
}