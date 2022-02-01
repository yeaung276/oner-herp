<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabAnalyzer extends Model 
{    
    protected $table = 'lab_analyzers';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
   
}
