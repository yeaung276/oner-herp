<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencyRecord extends Model 
{    
    protected $table = 'emergency_records';
    
    public $timestamps = false;
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'note',
        'state',
        'status'
    ];
    
    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }
}
