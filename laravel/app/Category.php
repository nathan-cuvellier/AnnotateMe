<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    protected $primaryKey = "id_cat";
    public $timestamps = false;

    protected $fillable = [
        'label_cat',
        'id_prj',
        'num_line',
    ];

}
