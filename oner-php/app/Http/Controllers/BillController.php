<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Bill;
use App\BillItem;
use App\BillReceipt;
use App\BillServiceItem;
use App\PatientServiceUsedRecord;
use App\PharmacySale;
use Illuminate\Support\Facades\Auth;
class BillController extends Controller
{
    // get all data
    public function all()
    {
        $bills = Bill::with('patient','billreceipt','billitem','payment')->get();
        return $this->respond('done', $bills);
    }
    // retrieve single data
    public function get($id)
    {
        $bill = Bill::with('patient','billreceipt','billitempsu.patient_service_used.service_item','billitem.service_used_item.category','payment')->find($id);
        if(is_null($bill)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$bill);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'patient_id' => 'required',
            'discount' => 'required',
            'status' => 'required',
        ]);

        try {
            $bill = $request->all();
            // $billitems = $bill['bill_items'];
            // unset($bill['bill_items']);
            // unset($bill['deposit']);
            $bill['created_user_id'] = Auth::user()->id;
            $bill['updated_user_id'] = 0;

            $billID = Bill::insertGetId($bill);
            // $billID = "test";
            $bill['id'] = $billID;
            
            $billitems = PatientServiceUsedRecord::where('patient_id',$bill['patient_id'])
            ->where('status','open')
            ->get();
            $billitemsData = [];
            foreach ($billitems as $value) {
                
                if($bill['status']==0){
                    $billitemsData_value['bill_id'] = $billID;
                    $billitemsData_value['patient_service_used_id'] = $value->id;
                    $billitemsData[] = $billitemsData_value;
                }

                // $patient_service_used_id = PatientServiceUsedRecord::where('patient_id',$bill['patient_id'])
                // ->where('service_item_id',$value->service_item_id)
                // ->first();
                $patient_service_used_id = PatientServiceUsedRecord::where('id',$value->id)
                ->first();

                // print_r($patient_service_used_id->toArray());
                // echo $bill['patient_id']."-".$value->service_item_id;
                // print_r($patient_service_used_id);
                if (!is_null($patient_service_used_id)) {

                    $patient_service_used_id->status = 'close';
                    $patient_service_used_id->update();
                }
                
            }
            BillItem::insert($billitemsData);
            
            
            // //return successful response
            return $this->respond('created', $bill);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'patient_id' => 'required',
            'discount' => 'required',
            // 'tax_amount' => 'required',
            'status' => 'required',
         ]);
        $bill = Bill::with('patient.open_pharmacy_sale')->find($id);
        if(is_null($bill)){
            return $this->respond('not_found');
        }

        $requestData['updated_user_id'] = Auth::user()->id;
        

        if($bill->status=="0" && isset($bill->patient->open_pharmacy_sale->id)){
            
            $sale = PharmacySale::find($bill->patient->open_pharmacy_sale->id);
            // print_r($bill->patient->open_pharmacy_sale->id);
            $sale->status=4;
            $sale->update();
        }
        $bill->update($request->all());

        return $this->respond('done', $bill);
    }
    // remove single row
    public function remove($id)
	{
		$bill = Bill::find($id);
		if(is_null($bill)){
            return $this->respond('not_found');
		}
		Bill::destroy($id);
        return $this->respond('removed',$bill);

	}

    
}