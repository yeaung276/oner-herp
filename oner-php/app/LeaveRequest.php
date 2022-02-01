<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model 
{    
    protected $table = 'leave_request';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'leave_date',
        'comment',
        'day_period',
        'created_user_id',
        'updated_user_id',
    ];
}
