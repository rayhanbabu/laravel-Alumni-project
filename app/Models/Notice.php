<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    protected $table='notices';
    protected $fillable =[
         'serial',
         'title',
         'admin_name',
         'category',
         'date',
         'text',
         'image',
      
    ];
}
