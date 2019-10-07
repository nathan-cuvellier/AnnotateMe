<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $primaryKey = "id_prj";
    public $timestamps = false;

    protected $fillable = ['id_prj','name_prj','script_prj','desc_prj','id_mode','id_int','id_exp','limit_prj'];
}