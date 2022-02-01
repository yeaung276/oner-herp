<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacyCategory extends Model 
{    
    protected $table = 'pharmacy_category';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'created_user_id',
        'updated_user_id'
    ];
}
