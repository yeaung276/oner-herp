<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model 
{    
    // protected $table = 'medical_record_prescription';
    protected $table = 'prescription';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'medical_record_id',
        // 'pharmacy_item_id',
        // 'quantity',
        'medical_record_id',
        'patient_id',
        'doctor_id',
        'created_user_id',
        'updated_user_id',
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }

    public function doctor(){
        return $this->hasOne('App\Doctor','id','doctor_id');
    }

    public function prescription_item(){
        return $this->hasMany('App\PrescriptionItem','prescription_id','id');
    }
}
