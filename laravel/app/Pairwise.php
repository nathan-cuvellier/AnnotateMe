<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pairwise extends Model
{
    protected $table = 'pairwise';
    protected $primaryKey = 'id_pair';
    public $timestamps = false;


    protected $fillable = [
        'id_pair',
        'id_exp',
        'id_data1',
        'id_data2',
        'date',
        'id_cat',
    ];
}
