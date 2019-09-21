<?php

namespace App;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class Interfaces extends Model
{
    protected $table = 'interface';
    protected $primaryKey = 'id_int';
    public $timestamps = false;
    protected $fillable = [
        'id_int', 'label_int', 'id_prj',
    ];
}