<?php

namespace App\Http\Controllers;

use App\Bill;
use App\BillServiceItem;
use App\Inventory;
use App\PharmacyInventoryTransaction;
use Illuminate\Http\Request;
use App\PharmacySale;
use App\PharmacySaleItem;
use Illuminate\Support\Facades\Auth;

class PharmacySaleController extends Controller
{
    // get all data
    public function all(Request $request)
    {
        if(!empty($request->get('page'))){
            $pharmacysales = PharmacySale::with('patient','doctor.employee', 'detail')->paginate();
        }else{
            $pharmacysales = PharmacySale::with('patient','doctor.employee', 'detail')->get();
        }
        
        return $this->respond('done', $pharmacysales);
    }
    // retrieve single data
    public function get($id)
    {
        $pharmacysale = PharmacySale::with('patient','doctor.employee','detail.pharmacy_item')->find($id);
        if (is_null($pharmacysale)) {
            return $this->respond('not_found');
        }
        return $this->respond('done', $pharmacysale);
    }
    public function getOPD(){
        $pharmacysales = PharmacySale::with('patient','doctor.employee')->where('remark','opd')->get();
        return $this->respond('done',$pharmacysales);
    }
    public function getIPD(){
        $pharmacysales = PharmacySale::with('patient','doctor.employee')->where('remark','ipd')->get();
        return $this->respond('done',$pharmacysales);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            // 'date' => 'required',
            'patient_id' => 'required',
            // 'total_amount' => 'required',
            // 'discount' => 'required',
            'remark' => 'required',
            'status' => 'required',
            // 'items' => 'required'
        ]);

        try {
            $pharmacysale = $request->all();
            $psdetail = $pharmacysale['items'];
            unset($pharmacysale['items']);
            $pharmacysale['date'] = "2020-11-18";
            // $pharmacysale['total_amount'] = "10000";
            $pharmacysale['created_user_id'] = Auth::user()->id;
            $pharmacysale['updated_user_id'] = 0;

            $PharmacySaleID = PharmacySale::insertGetId($pharmacysale);

            $pharmacysaledetail = [];
            $saleitemAmount = 0;
            foreach ($psdetail as $value) {
                $value['pharmacy_sale_id'] = $PharmacySaleID;
                $value['created_user_id'] = Auth::user()->id;
                $value['updated_user_id'] = "0";
                // unset($value['inventory_id']);
                $pharmacysaledetail[] = $value;
                $saleitemAmount = $value['amount'] + $saleitemAmount;
            }
            PharmacySaleItem::insert($pharmacysaledetail);

            // $filterBill = Bill::with('billitem')->where('patient_id', $pharmacysale['patient_id'])->where('status', '1')->first();

            // $bill['patient_id'] = $pharmacysale['patient_id'];
            // $bill['status'] = "1";
            // $bill['bill_date_time'] = $pharmacysale['date'];
            // $bill['created_user_id'] = Auth::user()->id;
            // $bill['updated_user_id'] = 0;


            // $serviceItem['service_id'] = $PharmacySaleID;
            // $serviceItem['service_type'] = "Sale";

            // print_r($filterBill->toArray());
            
            // if ($filterBill) {
                
            //     foreach($filterBill->billitem as $value){
            //         if($value->service_type=='Sale'){
            //             $_bsi = BillServiceItem::find($value->id);
            //             $serviceItem['charge'] = $value->charge+$saleitemAmount;
            //             $_bsi->update($serviceItem);
            //         }
            //     }
            // } else {
                
            //     $billId = Bill::insertGetId($bill);
            //     $serviceItem['bill_id'] = $billId;
            //     $serviceItem['charge'] = $saleitemAmount;

            //     // print_r($serviceItem);
            //     BillServiceItem::insert($serviceItem);
            //     $bill['patient_id'] = $pharmacysale['patient_id'];
            //     $bill['status'] = "1";
            //     $bill['bill_date_time'] = $pharmacysale['date'];
            //     $bill['created_user_id'] = Auth::user()->id;
            //     $bill['updated_user_id'] = 0;
                
            // }
            // Bill::insert($bill);
            //return successful response
            $pharmacysale['id'] = $PharmacySaleID;
            return $this->respond('created', $pharmacysale);
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
            // 'date' => 'required',
            'patient_id' => 'required',
            // 'total_amount' => 'required',
            // 'discount' => 'required',
            'remark' => 'required',
            'status' => 'required',
        ]);

        $psdetail = $requestData['items'];
        unset($requestData['items']);
        
        $pharmacysale = PharmacySale::find($id);
        if (is_null($pharmacysale)) {
            return $this->respond('not_found');
        }
        

        if($requestData['status']=='0'){
            $inventorytransaction = [];
            $_inv_update = [];
            $_err_id= '';
            $_flag=true;
            foreach ($psdetail as $value) {
                $inventorydata = Inventory::with('pharmacy.service_item')->where('id',$value['inventory_id'])->where('relation_id',$value['pharmacy_item_id'])->first();
                if(is_null($inventorydata)){
                    return $this->respond('not_found');
                }

                $_inventory = Inventory::where('id',$value['inventory_id'])->where('relation_id',$value['pharmacy_item_id'])->first();
                $_inv_update[$value['inventory_id']] = [
                    'relation_id' => $value['pharmacy_item_id'],
                    'balance' => $_inventory->balance - $value['quantity']
                ];
                
                $inventorytransaction_value['inventory_id'] = $value['inventory_id'];
                $inventorytransaction_value['relation_id'] = $inventorydata['relation_id'];
                $inventorytransaction_value['relation_type'] = 'pharmacy_item';
                $inventorytransaction_value['transaction_type'] = 'sale_order';
                $inventorytransaction_value['type'] = 'out';
                $inventorytransaction_value['quantity'] = $value['quantity'];
                $inventorytransaction_value['unit'] = $inventorydata['unit'];
                $inventorytransaction_value['moving_average_price'] = $inventorydata['selling_price'];
                $inventorytransaction_value['purchasing_price'] = $inventorydata['purchasing_price'];
                $inventorytransaction_value['selling_price'] = $inventorydata->pharmacy->service_item['charge'];
                $inventorytransaction_value['opening_balance'] = $inventorydata['balance'];
                $inventorytransaction_value['closing_balance'] = $inventorydata['balance']-$value['quantity'];
                $inventorytransaction_value['note'] = 'Pharmacy Sale Id: ' . $id;
                $inventorytransaction_value['created_user_id'] = Auth::user()->id;
                $inventorytransaction_value['updated_user_id'] = 0;

                $inventorytransaction[] = $inventorytransaction_value;

                if(($_inventory->balance-$value['quantity'])<0){
                    $_err_id=$_inventory->id;
                    $_flag=false;
                }
            }
            if($_flag==true){

                PharmacyInventoryTransaction::insert($inventorytransaction);
                foreach($_inv_update as $key => $up_val){
                    $_update = Inventory::where('id',$key)->where('relation_id',$up_val['relation_id'])->first();

                    $_update->balance = $up_val['balance'];
                    $_update->update();
                }
            }
        }
        if($_flag==true){
            $requestData['updated_user_id'] = Auth::user()->id;
            $pharmacysale->update($requestData);
            return $this->respond('done', $requestData);
        }else{
            return $this->respondMsg('not_valid',"ItemID - ".$_err_id." cannot out from inventory. (out of stock)");
        }
    }
    // remove single row
    public function remove($id)
    {
        $pharmacysale = PharmacySale::find($id);
        if (is_null($pharmacysale)) {
            return $this->respond('not_found');
        }
        PharmacySale::destroy($id);
        return $this->respond('removed', $pharmacysale);
    }
}
