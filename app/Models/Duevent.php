<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duevent extends Model
{
    use HasFactory;
    protected $table='duevents';
    protected $fillable =[
         'duclub_id',
         'invite',
         'year',
        
    ];
}
