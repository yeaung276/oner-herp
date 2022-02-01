<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestigationRequestItem extends Model
{
    protected $table = 'investigation_request_items';

    public $timestamps = false;
    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'investigation_items_id',
        'investigation_request_id',
        'sample_id',
        'attachement',
        'status',
        'remark',
        'result',
        'ranges',

    ];

    public function item()
    {
        return $this->hasOne('App\InvestigationItem', 'id', 'investigation_items_id');
    }

    public function request()
    {
        return $this->hasOne('App\InvestigationRequest', 'id', 'investigation_request_id');
    }
}
