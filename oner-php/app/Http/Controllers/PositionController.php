<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Position;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    // get all data
    public function all()
    {
        $positions = Position::all();
        return $this->respond('done', $positions);
    }
    // retrieve single data
    public function get($id)
    {
        $position = Position::find($id);
        if(is_null($position)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$position);
    }
    // validate and add row to db
    public function add(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
           'name' => 'required',
           'description' => 'required',
           
        ]);

        try {
            $position = $request->all();
            // $position['created_user_id'] = Auth::user()->id;
            // $position['updated_user_id'] = 0;
            Position::insert($position);
            //return successful response
            return $this->respond('created', $position);
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
            'description' => 'required',
         ]);
        $position = Position::find($id);
        if(is_null($position)){
            return $this->respond('not_found');
        }
        // $requestData['updated_user_id'] = Auth::user()->id;
        $position->update($requestData);
        return $this->respond('done', $position);
    }
    // remove single row
    public function remove($id)
	{
		$position = Position::find($id);
		if(is_null($position)){
            return $this->respond('not_found');
		}
		Position::destroy($id);
        return $this->respond('removed',$position);
	}
}