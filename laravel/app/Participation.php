<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $table = "participation";
    protected $primaryKey = "id_part";
    public $timestamps = false;

    protected $fillable = [
        'id_prj',
        'id_cptlvl',
        'id_exp',
    ];
}
