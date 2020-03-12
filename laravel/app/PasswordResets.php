<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    protected $table = "password_resets";
    protected $primaryKey = "id_password_resets";
    public $timestamps = false;

    protected $fillable = [
        'token',
        'created_at',
        'id_password_resets',
        'id_exp',
    ];
}
