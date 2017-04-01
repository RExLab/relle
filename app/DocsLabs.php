<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocsLabs extends Model {
    public $table = 'docs_labs';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'lab_id',
        'doc_id'
    ];
}
