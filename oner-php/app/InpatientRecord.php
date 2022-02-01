<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InpatientRecord extends Model 
{    
    protected $table = 'inpatient_records';
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
        'admited_date',
        'discharged_date',
        'bed_id',
        'admit_form_id',
        'discharge_form_id',
        'status',
        'created_user_id',
        'updated_user_id',
    ];
    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }
    public function bed(){
        return $this->hasOne('App\InpatientBed','id','bed_id');
    }
    // public function admit_form(){
    //     return $this->hasMany('App\BillReceipt','bill_id','id');
    // }
    // public function discharge_form(){
    //     return $this->hasMany('App\BillServiceItem','bill_id','id');
    // }

}
