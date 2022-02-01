<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacySale extends Model 
{    
    protected $table = 'pharmacy_sale';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // {"patient_id":"6","doctor_id":"9","buyer_name":"name(Optional)","buyer_nrc":"nrc(Optional)","buyer_address":"address(Optional)","remark":"remark(Optional)","status":"open/paid/close"}

    protected $fillable = [
        'date',
        'patient_id',
        'doctor_id',
        'buyer_name',
        'buyer_nrc',
        'buyer_address',
        'total_amount',
        // 'discount',
        'remark',
        'status',
        'created_user_id',
        'updated_user_id',
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }

    public function doctor(){
        return $this->hasOne('App\Doctor','id','doctor_id');
    }

    public function detail(){
        return $this->hasMany('App\PharmacySaleItem','pharmacy_sale_id','id');
    }
}
