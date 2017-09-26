<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'user';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['email','firstname','lastname','password','remember_token','renew_password_hash'];

}
