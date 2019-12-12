<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = "data";
    protected $primaryKey = "id_data";
    public $timestamps = false;

    protected $fillable = [
        'pathname_data',
        'priority_data',
        'nbannotation_data',
        'id_prj',
    ];
}
