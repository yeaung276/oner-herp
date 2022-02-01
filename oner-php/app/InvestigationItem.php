<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestigationItem extends Model 
{    
    protected $table = 'investigation_items';
    
    public $timestamps = false;
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'investigation_category_id',
        'investigation_department_id',
        'investigation_item_name',
        'description',
        'unit',
        'attachement_flag',
        'ranges'
        // 'service_item_id',
    ];

    public function category(){
        return $this->hasOne('App\InvestigationCategory','id','investigation_category_id');
    }

    public function department(){
        return $this->hasOne('App\InvestigationDepartment','id','investigation_department_id');
    }

    public function ranges(){
        return $this->hasMany('App\InvestigationItemRange','investigation_item_id','id');
    }

    public function service_item(){
        return $this->hasOne('App\ServiceItem','relation_id','id')->where('service_type','investigation_item');
    }
}
