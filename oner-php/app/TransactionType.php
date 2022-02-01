<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model 
{    
    protected $table = 'transaction_types';
    
    public $timestamps = false;
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
    ];

   
}
