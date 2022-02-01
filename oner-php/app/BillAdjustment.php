<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillAdjustment extends Model 
{    
    protected $table = 'billing_adjustments';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'counter',
        'type',
        'amount',
        'payment_id',
        'reason',
        'created_user_id',
        'updated_user_id',
    ];
}
