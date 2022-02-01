<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{    
    protected $table = 'employee';

    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_identification_number',
        'name',
        'gender',
        'education',
        'join_date',
        'permanent_date',
        'marital_status',
        'number_of_children',
        'live_with_parent',
        'live_with_spouse_parent',
        'phone_number',
        'emergency_contact_phone',
        'date_of_birth',
        'nrc_number',
        'bank_account_number',
        'tax_id',
        'passport_number',
        'address',
        'profile_image',
        'position_id',
        'department_id',
        'status',
        'created_user_login_id',
        'updated_user_login_id',
    ];

    protected $hidden = [
        'department_id',
        // 'employee_id'
    ];
    public function department(){
        return $this->hasOne("App\Department",'id','department_id');
    }
    public function position(){
        return $this->hasOne("App\Position",'id','position_id');
    }
}
