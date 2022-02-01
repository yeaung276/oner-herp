<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model 
{    
    protected $table = 'patient';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nrc',
        'phone',
        'age',
        'date_of_birth',
        'address',
        
        // 'township',
        // 'region',
        'blood_group',
        'gender',
        'status',
    ];

    public function medical_record(){
        return $this->hasMany('App\MedicalRecord','patient_id','id');
    }

    public function open_pharmacy_sale(){
        return $this->hasOne('App\PharmacySale','patient_id','id')->where('status','0');
    }
    
}
