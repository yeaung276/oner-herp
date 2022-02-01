<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{    
    protected $table = 'payment';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bill_id',
        'collected_amount',
        'patient_id',
        'created_user_id',
        'updated_user_id',
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }

    public function bill(){
        return $this->hasOne('App\Bill','id','bill_id');
    }
    
}
