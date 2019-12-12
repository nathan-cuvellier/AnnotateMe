<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LimitAnnotation extends Model
{
    protected $table = 'limit_annotation';
    protected $primaryKey = 'id_limit_annotation';
    public $timestamps = false;


    protected $fillable = [
        'id_limit_annotation',
        'id_exp',
        'id_prj',
        'date_limit_annotation',
    ];
}
