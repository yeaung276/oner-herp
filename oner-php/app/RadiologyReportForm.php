<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadiologyReportForm extends Model 
{    
    protected $table = 'radiology_report_forms';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        
        'patient_id',
        'type',
        'film_no',
        'examination',
        'technique',
        'finding',
        'comment',
        'created_user_id',
        'updated_user_id'
        
    ];
}
