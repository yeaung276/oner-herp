<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencyRoom extends Model 
{    
    protected $table = 'emergency_rooms';
    
    public $timestamps = false;
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_id',
        'location',
    ];
   
}
