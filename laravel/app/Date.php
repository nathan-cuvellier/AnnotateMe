<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $table = 'date';

    protected $primaryKey = 'date'; // or null
    public $incrementing = false;

    public $timestamps = false;
}