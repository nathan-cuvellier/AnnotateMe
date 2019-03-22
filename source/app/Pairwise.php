<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pairwise extends Model
{
    protected $table = 'pairwise';
    protected $primaryKey = "id_pair";
    public $timestamps = false;
}
