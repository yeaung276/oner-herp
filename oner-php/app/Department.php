<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model 
{    
    protected $table = 'department';
    
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
