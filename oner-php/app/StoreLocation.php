<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreLocation extends Model 
{    
    protected $table = 'store_locations';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'detail',
    ];
   
}
