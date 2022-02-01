<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model 
{    
    protected $table = 'bill';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // {"patient_id":"1","total_cost":"1000","tax":"1000","discount":"1000",
    // "deposit":[{"deposit_id":1},{"deposit_id":2}],"total_payment":"4000","bill_items":[{"patient_service_used_id":1},{"patient_service_used_id":2}]}
    protected $fillable = [
        'patient_id',
        'counter',
        'patient_type',
        'inpatient_care_id',
        'emergency_care_id',
        'appointment_id',
        'bill_date_time',
        'discount',
        'total_cost',
        'total_payment',
        'tax',
        'discharge_date_time',
        'status',
        'created_user_id',
        'updated_user_id',
    ];
    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }
    public function billitempsu(){
        return $this->hasMany('App\BillItem','bill_id','id');
    }
    public function billreceipt(){
        return $this->hasMany('App\BillReceipt','bill_id','id');
    }
    public function billitem(){
        return $this->hasMany('App\BillServiceItem','bill_id','id');
    }

    public function salebill(){
        return $this->hasOne('App\BillReceipt','bill_id','id');
    }
    public function payment(){
        return $this->hasMany('App\Payment','bill_id','id');
    }
}
