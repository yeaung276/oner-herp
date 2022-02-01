<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class Controller extends BaseController
{
    protected $statusCodes = [
		'done' => [ 'status'=> 200 , 'message'=> 'Done'],
		'created' => [ 'status'=> 201 , 'message' => 'Created'],
		'removed' => [ 'status'=> 200 , 'message' => 'Removed'],
		'not_valid' => [ 'status'=> 400 , 'message' => 'Not Valid'],
		'not_found' => [ 'status'=> 404 , 'message' => 'Not Found'],
		'conflict' => [ 'status'=> 409 , 'message' => 'Conflit'],
		'permissions' => [ 'status'=> 401 , 'message' => 'Permission'],
	];
    
    public function uploadImage(Request $request,$field, $path)
    {
        // $response = null;
        // $user = (object) ['image' => ""];

        if ($request->hasFile($field)) {
            $original_filename = $request->file($field)->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/'.$path;
            $image = 'Img-' . time() . '.' . $file_ext;

            if ($request->file($field)->move($destination_path, $image)) {
                // $user->image = '/upload/'.$path . $image;
                // return $this->responseRequestSuccess($user);
                return '/upload/'.$path.'/'. $image;
            } else {
                // return $this->responseRequestError('Cannot upload file');
                return false;
            }
        } else {
            // return $this->responseRequestError('File not found');
            return false;
        }
    }

    protected function responseRequestSuccess($ret)
    {
        return response()->json(['status' => 'success', 'data' => $ret], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json(['status' => 'error', 'error' => $message], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 1440,
            'user_level' => Auth::user()->level,
        ], 200);
    }
    protected function respond($status, $data = [])
    {
    	return response()->json([ 'data'=>$data,'message'=>$this->statusCodes[$status]['message'] ], $this->statusCodes[$status]['status']);
    }
    protected function respondMsg($status, $message)
    {
    	return response()->json(['message'=>$message ], $this->statusCodes[$status]['status']);
    }
}
