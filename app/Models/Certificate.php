<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificate';
    protected $primaryKey = 'id';
    protected $fillable = [ 'users_id',  'certificate', 'start_certificate','end_certificate'];

}