<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisReportItem extends Model 
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
        'diagnosis_report_id',
        'diagnosis_item_id',
        'result',
        'remark',
        'file_attachment',
    ];
}
