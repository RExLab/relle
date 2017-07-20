<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {
    public $timestamps = false;
    protected $fillable = [
        'lab_id',
        'user_id',
        'start',
        'end',
        'ip',
        'os',
        'browser',
        'mobile',
        'language',
        'country',
        'city',
        'lat',
        'lon'
    ];

}
