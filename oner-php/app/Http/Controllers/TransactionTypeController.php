<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\TransactionType;

class TransactionTypeController extends Controller
{
    // get all data
    public function all()
    {
        $transactiontypes = TransactionType::get();
        return $this->respond('done', $transactiontypes);
    }
    // retrieve single data
    public function get($id)
    {
        $transactiontype = TransactionType::find($id);
        if(is_null($transactiontype)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$transactiontype);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
        //    'status' => 'required'
        ]);

        try {
            $transactiontype = $request->all();

            TransactionType::insert($transactiontype);
            //return successful response
            return $this->respond('created', $transactiontype);
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
         ]);
        $transactiontype = TransactionType::find($id);
        if(is_null($transactiontype)){
            return $this->respond('not_found');
        }
        $transactiontype->update($request->all());
        return $this->respond('done', $transactiontype);
    }
    // remove single row
    public function remove($id)
	{
		$transactiontype = TransactionType::find($id);
		if(is_null($transactiontype)){
            return $this->respond('not_found');
		}
		TransactionType::destroy($id);
        return $this->respond('removed',$transactiontype);

	}

    
}