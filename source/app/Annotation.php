<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $table = 'annotation';
    protected $primaryKey = "id_annot";
    public $timestamps = false;
}
