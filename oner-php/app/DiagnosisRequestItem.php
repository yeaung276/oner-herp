<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisRequestItem extends Model 
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
        'diagnosis_request_id',
        'diagnosis_item_id',
        'charge',
    ];
}
