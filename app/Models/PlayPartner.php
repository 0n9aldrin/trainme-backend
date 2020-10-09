<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayPartner extends Model
{
    protected $table = 'play_partner';
    protected $primaryKey = 'pp_id';
    protected $fillable = ['pp_id', 'partner_id', 'play_id', 'status',  'reason', 'notes'];

}