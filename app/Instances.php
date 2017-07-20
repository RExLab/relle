<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instances extends Model {

    protected $fillable = [
        'id',
        'lab_id',
        'address',
        'description',
        'maintenance',
        'duration',
        
    ];

}
