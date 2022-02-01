<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model 
{    
    protected $table = 'leave_type';
    
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'allowance_days_per_year',
        
    ];
}
