<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Play extends Model
{
    protected $table = 'play';
    protected $primaryKey = 'play_id';
    protected $fillable = ['play_id', 'user_id',  'sparing_date', 'expired_date', 'title' , 'address' , 'time', 'desription', 'play_type', 'level'];

}