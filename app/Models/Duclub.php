<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duclub extends Model
{ 
    use HasFactory;
    protected $table='duclubs';
    protected $fillable =[
         'otp',
         'phone',
         'name',
         'phone',
         'member_id',
         'member_card',
         'designation',
         'dept',
         'email',
    ];

}
