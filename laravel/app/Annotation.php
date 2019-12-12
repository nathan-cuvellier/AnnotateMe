<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $table = 'annotation';
    protected $primaryKey = 'id_annot';
    public $timestamps = false;


    protected $fillable = [
        'id_annot',
        'id_exp',
        'id_cat',
        'id_data',
        'date',
        'expert_sample_confidence_level',
    ];

}
