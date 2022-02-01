<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model 
{    
    protected $table = 'supplier';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dealer',
        'company',
        'credit_term',
        'contact',
        'address',
        'remark',
        'created_user_id',
        'updated_user_id',
    ];

}
