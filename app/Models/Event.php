<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'event_id';
    protected $fillable = ['name', 'description',  'location', 'organizer', 'date' , 'is_active' ,'poster'];

}