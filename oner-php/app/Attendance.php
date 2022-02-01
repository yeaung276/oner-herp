<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model 
{    
    protected $table = 'attendance';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'time_in',
        'time_out',
        'created_user_id',
        'updated_user_id',
    ];
}
