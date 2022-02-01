<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model 
{    
    protected $table = 'bill_items';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bill_id',
        'patient_service_used_id',
    ];
   
    public function patient_service_used(){
        return $this->hasOne('App\PatientServiceUsedRecord','id','patient_service_used_id');
    }
    
}
