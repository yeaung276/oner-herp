<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model 
{    
    protected $table = 'deposits';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'collected_amount',
        'status',
        'created_user_id',
        'updated_user_id',
    ];

    public function patient(){
        return $this->hasOne('App\Patient','id','patient_id');
    }

    
}
