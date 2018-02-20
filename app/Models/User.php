<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = array('username', 'plain_password');
    protected $hidden = ['id', 'password', 'created_at', 'updated_at'];
    protected $table = "users";

}