<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencyPatient extends Model 
{    
    protected $table = 'emergency_patients';
    
    public $timestamps = false;
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'bed_id',
        'start_date',
        'end_date',
        'status',
        'operation',
        'note',
        'ot_labour'
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }
    
    public function bed(){
        return $this->hasOne('App\EmergencyBed','id','bed_id');
    }
}
