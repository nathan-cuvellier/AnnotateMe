<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tripletwise extends Model
{
    protected $table = 'tripletwise';
    protected $primaryKey = "id_triplet";
    public $timestamps = false;
}