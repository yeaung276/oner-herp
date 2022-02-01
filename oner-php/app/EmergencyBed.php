<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergencyBed extends Model 
{    
    protected $table = 'emergency_beds';
    
    public $timestamps = false;
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emergency_room_id',
        'location',
        'status',
    ];

    public function room(){
        return $this->hasOne('App\EmergencyRoom','id','emergency_room_id');
    }
   
}
