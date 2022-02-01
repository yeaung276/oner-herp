<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillReceipt extends Model 
{    
    protected $table = 'bill_receipt';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bill_id',
        'date',
        'amount',
        'status',
        'created_user_id',
        'updated_user_id',
    ];
}
