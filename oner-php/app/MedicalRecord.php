<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model 
{    
    protected $table = 'medical_record';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'record_type',
        'patient_id',
        'weight',
        'height',
        'blood_pressure',
        'temperature',
        'pulse_rate',
        'respiratory_rate',        
        'doctor_accessment',
        'diagnosis',
        'investigation',
        'attachment',
	'nurse_remark',
        'treatment_procedures',
        'created_user_id',
        'updated_user_id',
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }
}
