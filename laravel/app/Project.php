<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $primaryKey = "id_prj";
    public $timestamps = false;

    protected $fillable = [
        'id_prj',
        'name_prj',
        'desc_prj',
        'id_mode',
        'id_int',
        'id_exp',
        'value_mode',
        'limit_prj',
        'waiting_time_prj',
        'online_prj'
    ];
}
