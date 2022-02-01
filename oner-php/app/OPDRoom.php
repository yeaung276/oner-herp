<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OPDRoom extends Model 
{    
    protected $table = 'opd_room';
    // const CREATED_AT = 'created_time';
    // const UPDATED_AT = 'updated_time';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'current_doctor_id',
        'current_queue_token',
    ];

    public function doctor(){
        return $this->hasOne('App\Doctor','id','current_doctor_id');
    }
    public function appointment(){
        return $this->hasMany('App\Appointment','opd_room_id','id');
    }
    public function current(){
        return $this->hasOne('App\Appointment','queue_ticket_number','current_queue_token');
    }
}
