<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $fillable = array('username', 'password', 'facebook_id');
    protected $hidden = ['id', 'created_at', 'updated_at'];
    protected $table = "users";

}