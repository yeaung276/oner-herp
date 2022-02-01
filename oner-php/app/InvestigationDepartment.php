<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestigationDepartment extends Model
{
    protected $table = 'investigation_departments';

    public $timestamps = false;
    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

}
