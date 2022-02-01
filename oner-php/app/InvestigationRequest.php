<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestigationRequest extends Model
{
    protected $table = 'investigation_requests';

    public $timestamps = false;
    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'medical_record_id',
        'investigation_report_id',
        'requested_doctor_id',
        'assigned_doctor_id',
        'request_doctor_note',
        'assigned_doctor_note',
        'cost',
        'status',
    ];

    public function patient()
    {
        return $this->hasOne('App\Patient', 'id', 'patient_id');
    }

    public function requested_doctor()
    {
        return $this->hasOne('App\Doctor', 'id', 'requested_doctor_id');
    }

    public function assigned_doctor()
    {
        return $this->hasOne('App\Doctor', 'id', 'assigned_doctor_id');
    }

    public function request_items(){
        return $this->hasMany('App\InvestigationRequestItem','investigation_request_id','id');
    }

}
