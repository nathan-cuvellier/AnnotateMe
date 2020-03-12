<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Triplewise extends Model
{
    protected $table = 'triplewise';
    protected $primaryKey = 'id_triplet';
    public $timestamps = false;


    protected $fillable = [
        'id_triplet',
        'id_exp',
        'id_data1',
        'id_data2',
        'id_data3',
        'date',
        'id_cat',
        'expert_sample_confidence_level',
    ];
}
