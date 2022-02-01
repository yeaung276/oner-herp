<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacySaleReceipt extends Model 
{    
    protected $table = 'pharmacy_sale_receipt';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pharmacy_sale_id',
        'date',
        'amount',
        'status',
        'created_user_id',
        'updated_user_id',
    ];
}
