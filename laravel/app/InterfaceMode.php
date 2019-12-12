<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterfaceMode extends Model
{
    protected $table = 'interface';
    protected $primaryKey = 'id_int';
    public $timestamps = false;
    protected $fillable = [
        'id_int',
        'label_int',
        'id_prj',
    ];
}
