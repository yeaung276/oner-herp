<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacyInventory extends Model 
{    
    protected $table = 'pharmacy_inventory';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pharmacy_item_id',
        'balance',
        'average_price',
        'purchasing_price',
        
        'created_user_id',
        'updated_user_id',
    ];
}
