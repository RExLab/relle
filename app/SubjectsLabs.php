<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectsLabs extends Model {
    public $table = 'subjects_labs';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'lab_id',
        'subject_id'
    ];
}
