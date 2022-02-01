<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralItem extends Model 
{    
    protected $table = 'general_items';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'uom',
        'po_uom',
        'unit_conversion_id',
    ];
   
}
