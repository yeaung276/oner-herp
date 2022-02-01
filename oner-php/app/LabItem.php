<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabItem extends Model 
{    
    protected $table = 'lab_items';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'part_number',
        'product_name',
        'abbr',
        'lab_analyzers_id',
        'type',
        'description',
        'brand',
        'country',
        'unit',
        'cost_per_test',
        'estimated_tests',
        'uom',
        'po_uom',
        'unit_conversion_id',
    ];

    public function analyzers(){
        return $this->hasOne('App\LabAnalyzer','id','lab_analyzers_id');
    }

    public function inventory(){
        return $this->belongsTo('App/Inventory');
    }
   
}
