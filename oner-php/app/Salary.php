<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model 
{    
    protected $table = 'salary';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'basic_monthly_rate',
        'overtime_hourly_rate',
        'created_user_id',
        'updated_user_id',
    ];
}
