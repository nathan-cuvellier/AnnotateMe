<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionMode extends Model
{
    protected $table = 'session_mode';
    protected $primaryKey = "id_mode";
    public $timestamps = false;
}