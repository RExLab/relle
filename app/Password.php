<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model{
    public $table = 'password_resets';
    protected $fillable = ['email', 'token', 'created_at'];
}