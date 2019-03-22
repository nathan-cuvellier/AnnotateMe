<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenceLevel extends Model
{
    protected $table = 'competence_level';
    protected $primaryKey = "id_cptlvl";
    public $timestamps = false;
}