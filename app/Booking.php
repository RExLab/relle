<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    public $table = "booking";

    protected $fillable = [
        'id',
        'lab_id',
        'date',
        'time',
        'duration',
        'token',
        'created_by',
        'timestamp_enter',
        'timestamp_left',
    ];

}
