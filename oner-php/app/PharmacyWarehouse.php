<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacyWarehouse extends Model 
{    
    protected $table = 'pharmacy_warehouse';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'created_user_id',
        'updated_user_id',
    ];
}
