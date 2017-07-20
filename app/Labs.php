<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labs extends Model {

    public $timestamps = false;
    protected $fillable = [
        'id',
        'name_pt',
        'name_en',
        'description_pt',
        'description_en',
        'tags',
        'duration',
        'resources',
        'target',
        'subject',
        'difficulty',
        'interaction',
        'thumbnail',
        'maintenance',
        'queue',
        'tutorial_pt',
        'tutorial_en',
        'video'
    ];

}
