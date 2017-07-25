<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docs extends Model {

    protected $fillable = [
        'id',
        'type',
        'title',
        'size',
        'format',
        'lang',
        'tags',
        'url',
        'created_at',
        'updated_at'
    ];

}
