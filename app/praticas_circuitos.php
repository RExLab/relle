<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Praticas_circuitos extends Model {

    protected $fillable = [
        'id',
        'nome',
        'descri',
        'img_visir',
        'img_diagrama',
        'arquivo',
        
    ];
}

?>