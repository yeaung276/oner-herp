<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisRequest extends Model 
{    
    protected $table = 'diagnosis_request';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'date',
        'doctor_id',
        'status',
        'notes',
        'created_user_id',
        'updated_user_id',
    ];
}
