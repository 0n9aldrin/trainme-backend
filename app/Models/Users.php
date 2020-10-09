<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'name', 'email',  'password', 'image', 'role', 'phone_number', 'address', 'price', 'experience', 'birthdate', 'utr', 'level', 'gender'];

}