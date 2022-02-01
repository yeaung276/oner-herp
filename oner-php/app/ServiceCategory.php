<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model 
{    
    protected $table = 'service_category';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];
}
