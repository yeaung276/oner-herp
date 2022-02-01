<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\LabAnalyzer;

class LabAnalyzerController extends Controller
{
    // get all data
    public function all()
    {
        $labanalyzers = LabAnalyzer::get();
        return $this->respond('done', $labanalyzers);
    }
    // retrieve single data
    public function get($id)
    {
        $labanalyzer = LabAnalyzer::find($id);
        if(is_null($labanalyzer)){
            return $this->respond('not_found'); 
        }   
        return $this->respond('done',$labanalyzer);
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
            $labanalyzer = $request->all();

            LabAnalyzer::insert($labanalyzer);
            //return successful response
            return $this->respond('created', $labanalyzer);
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
        $labanalyzer = LabAnalyzer::find($id);
        if(is_null($labanalyzer)){
            return $this->respond('not_found');
        }
        $labanalyzer->update($request->all());
        return $this->respond('done', $labanalyzer);
    }
    // remove single row
    public function remove($id)
	{
		$labanalyzer = LabAnalyzer::find($id);
		if(is_null($labanalyzer)){
            return $this->respond('not_found');
		}
		LabAnalyzer::destroy($id);
        return $this->respond('removed',$labanalyzer);

	}

    
}