<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InpatientBed extends Model 
{    
    protected $table = 'inpatient_beds';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bed_name',
        'room_id',
        'type', 
        'bed_charge',
        'created_user_id',
        'updated_user_id',
    ];

    public function room(){
        return $this->hasOne('App\InpatientRoom','id','room_id');
    }

}
