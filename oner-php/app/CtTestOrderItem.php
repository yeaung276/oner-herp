<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtTestOrderItem extends Model 
{    
    protected $table = 'ct_test_order_items';
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        
        'ct_test_order_id',
        'investigation_item_id',
        'result',
        'status',
        'created_user_id',
        'updated_user_id'
        
    ];

    public function investigation_item(){
        return $this->hasOne('App\InvestigationItem','id','investigation_item_id');
    }
}
