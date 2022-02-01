<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model 
{    
    protected $table = 'doctor';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'name',
        // 'phone',
        'employee_id',
        // 'opd_room_id',
        'opd_charge',
        'ipd_charge',
        'schedule'
    ];

    protected $hidden = [
        'department_id',
        'employee_id'
    ];

    public function department(){
        return $this->hasOne("App\Department",'id','department_id');
    }
    public function employee(){
        return $this->hasOne("App\Employee",'id','employee_id')->select('id','department_id','name','phone_number','position_id');
    }
    public function opd(){
        return $this->hasOne("App\OPDRoom",'current_doctor_id','id');
    }
}
