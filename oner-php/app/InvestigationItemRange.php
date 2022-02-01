<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestigationItemRange extends Model
{
    protected $table = 'investigation_item_ranges';

    public $timestamps = false;
    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'marker',
        'lower_limit',
        'upper_limit',
        'investigation_item_id'
    ];

}
