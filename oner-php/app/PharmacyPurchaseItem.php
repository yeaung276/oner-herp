<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacyPurchaseItem extends Model 
{    
    protected $table = 'pharmacy_purchase_item';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pharmacy_purchase_id',
        'pharmacy_item_id',
        'quantity',
        'purchase_price',
        'amount',
        'created_user_id',
        'updated_user_id',
    ];
}
