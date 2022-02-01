<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmacyIssueItem extends Model 
{    
    protected $table = 'pharmacy_issue_item';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pharmacy_issue_id',
        'pharmacy_item_id',
        'inventory_id',
        'quantity',
        'sale_price',
        'amount',
        'created_user_id',
        'updated_user_id',
    ];

    public function pharmacy_item(){
        return $this->hasOne('App\PharmacyItem','id','pharmacy_item_id');
    }
}
