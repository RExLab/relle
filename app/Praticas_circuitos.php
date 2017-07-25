<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instances extends Model {

    protected $fillable = [
        'id',
        'nome',
        'desc',
        'img_visir',
        'img_diagrama',
        'download',
        
    ];
}

?>