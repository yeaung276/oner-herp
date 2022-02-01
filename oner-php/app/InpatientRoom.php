<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InpatientRoom extends Model 
{    
    protected $table = 'inpatient_rooms';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_no',
        'floor',       
        'created_user_id',
        'updated_user_id',
    ];
   

}
