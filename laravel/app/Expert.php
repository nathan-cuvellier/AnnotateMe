<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{

    protected $table = 'expert';
    protected $primaryKey = 'id_exp';
    public $timestamps = false;


    protected $fillable = [
        'id_exp',
        'name_exp',
        'firstname_exp',
        'bd_date_exp',
        'sex_exp',
        'address_exp',
        'pc_exp',
        'mail_exp',
        'tel_exp',
        'city_exp',
        'pwd_exp',
        'type_exp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pwd_exp',
    ];
}
