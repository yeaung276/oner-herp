<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model 
{    
    protected $table = 'service_item';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_type',
        'relation_id',
        'name',
        'description',
        'charge',
    ];

    // public function category(){
    //     return $this->hasOne('App\ServiceCategory','id','service_category_id');
    // }
}
