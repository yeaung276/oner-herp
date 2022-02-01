<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Inventory;
use Carbon\Carbon;

class InventoryController extends Controller
{
    // get all data
    public function all()
    {
        $inventorys['lab_items'] = Inventory::with('location','lab')
        ->where('type','=','lab')
        ->get();
        $inventorys['general_items'] = Inventory::with('location','general')
        ->where('type','=','general')
        ->get();
        $inventorys['pharmacy_items'] = Inventory::with('location','pharmacy.service_item')
        ->where('type','=','pharmacy_item')
        ->get();
        return $this->respond('done', $inventorys);
    }
    // get by location id
    public function byLocation($location_id){
        $inventorys = Inventory::with('location','pharmacy.service_item')->where('location_id',$location_id)->get();
        return $this->respond('done', $inventorys);
    }
    public function getSaleItem($location_id){
        $inventorys = Inventory::with('location','pharmacy.service_item')->where('location_id',$location_id)->where('balance','>',0)->get();
        return $this->respond('done', $inventorys);
    }
    public function getall()
    {
        $inventorys = Inventory::all();
       
        return $this->respond('done', $inventorys);
    }
    // retrieve single data
    public function get($id)
    {
        $inventory = Inventory::with('location','lab','general','pharmacy.service_item','transactions')->find($id);
        if(is_null($inventory)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$inventory);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'relation_id' => 'required'
        ]);

        try {
            $inventory = $request->all();

            $inventory['id'] = Inventory::insertGetId($inventory);
            //return successful response
            return $this->respond('created', $inventory);
        } catch (\Exception $e) {
            //return error message
            return $this->respond('not_valid', $e);
        }
    }
    // single row update
    public function put($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'relation_id' => 'required'
         ]);
        $inventory = Inventory::find($id);
        if(is_null($inventory)){
            return $this->respond('not_found');
        }
        $inventory->update($request->all());
        return $this->respond('done', $inventory);
    }
    // remove single row
    public function remove($id)
	{
		$inventory = Inventory::find($id);
		if(is_null($inventory)){
            return $this->respond('not_found');
		}
		Inventory::destroy($id);
        return $this->respond('removed',$inventory);
	}

    public function expiryitems(){
        // $inventory = Inventory::get();
        // echo "2012-08-08 00:00:00.000000" ." < ".Carbon::now()->subMonths(6);
        // exit;
        $inventorys['lab_items'] = Inventory::with('location','lab')
        ->where('type','=','lab')
        ->where('expiry_date',">", Carbon::now()->subMonths(6))
        ->where('balance',">", "0")
        ->get();

        $inventorys['general_items'] = Inventory::with('location','general')
        ->where('type','=','general')
        ->where('expiry_date',"<", Carbon::now()->subMonths(6))
        ->where('balance',">", "0")
        ->get();
        
        $inventorys['pharmacy_items'] = Inventory::with('location','pharmacy')
        ->where('type','=','pharmacy')
        ->where('expiry_date',"<", Carbon::now()->subMonths(6))
        ->where('balance',">", "0")
        ->get();

        return $this->respond('done', $inventorys);
    }
}
