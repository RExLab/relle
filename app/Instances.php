<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instances extends Model {
    public $table = 'instances';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'lab_id',
        'address',
        'description',
        'maintenance',
        'queue',
    ];

}
 