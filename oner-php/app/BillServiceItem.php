<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillServiceItem extends Model 
{    
    protected $table = 'bill_service_item';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bill_id',
        'service_id',
        'service_type',
        'charge',
    ];

    public function serviceitem(){
        return $this->hasOne('App\ServiceItem','id','service_item_id');
    }
    public function service_used_item(){
        return $this->hasOne('App\PatientServiceUsedRecord','id','service_item_id');
    }
    
    
}
