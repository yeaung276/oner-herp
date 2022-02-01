<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisReport extends Model 
{    
    protected $table = 'diagnosis_report';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diagnosis_request_id',
        'date',
        'doctor_id',
        'notes',
        'created_user_id',
        'updated_user_id',
    ];
}
