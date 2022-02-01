<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacyUnitConversion extends Model 
{    
    protected $table = 'pharmacy_unit_conversion';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pharmacy_item_id',
        'sku_name',
        'sku_quantity',
        'po_uom_name',
        'po_uom_quantity',
        'created_user_id',
        'updated_user_id',
    ];
}
