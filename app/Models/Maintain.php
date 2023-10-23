<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintain extends Model
{
    use HasFactory;
    protected $table='maintains';
    protected $fileable =[
         'name',
         'email',
         'mobile',
         'maintain_name',
         'maintain_password',
         'role',
    
    ];
}
