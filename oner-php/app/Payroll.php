<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model 
{    
    protected $table = 'payroll';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'basic_salary',
        'overtime_fee',
        'bonus',
        'tax',
        'deduction',
        'month',
        'year',
        'notes',
        'created_user_id',
        'updated_user_id',
    ];
}
