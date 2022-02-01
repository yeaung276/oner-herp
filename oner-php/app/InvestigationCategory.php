<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestigationCategory extends Model 
{    
    protected $table = 'investigation_categorys';
    
    public $timestamps = false;
    // public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'investigation_category_name',
        'description',
    ];

    public function items(){
        return $this->hasMany('App\InvestigationItem','investigation_category_id','id');
    }
   
}
