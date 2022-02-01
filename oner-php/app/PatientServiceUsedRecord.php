<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientServiceUsedRecord extends Model 
{    
    protected $table = 'patient_service_used_records';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'patient_id',
        'service_item_id',
        'quantity',
        'charge',
        'total_charge',
        'status',
        'extra',
        'created_user_id',
        'updated_user_id',
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }

    public function service_item(){
        return $this->hasOne('App\ServiceItem','id','service_item_id');
    }
    
}
