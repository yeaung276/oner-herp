<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadiologyRequestForm extends Model 
{    
    protected $table = 'radiology_request_forms';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'type',
        'patient_id',
        'occupation',
        'hospital_number',
        'rn',
        'opd_clinic',
        'referred_doctor_id',
        'external_requestor',
        'doctor_to_provide_report',
        'doctor_accepting_request',
        'clinical_note',
        'previous_imaging',
        'previous_surgery_radiotherapy',
        'laboratory_findings',
        'clinical_diagnosis',
        'examination_requested',
        'exam_questions',
        'tests',
        'created_user_id',
        'updated_user_id'
    ];
}
