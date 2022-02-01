<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtTestOrder extends Model 
{    
    protected $table = 'ct_test_orders';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        
        'patient_id',
        'doctor_id',
        'request_form',
        'consent_form',
        'request_form_id',
        'report_form_id',
        'status',
        'consumption',
        'created_user_id',
        'updated_user_id'
        
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }
    public function doctor(){
        return $this->hasOne('App\Doctor','id','doctor_id');
    }
    public function ctto_items(){
        return $this->hasMany('App\CtTestOrderItem','ct_test_order_id','id');
    }
}
