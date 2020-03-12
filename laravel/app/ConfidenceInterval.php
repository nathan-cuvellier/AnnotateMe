<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfidenceInterval extends Model
{
    protected $table = "confidence_interval";
    protected $primaryKey = "id_confidence_interval";
    public $timestamps = false;

    protected $fillable = [
        'id_confidence_interval',
        'label_confidence_interval',
    ];
}
