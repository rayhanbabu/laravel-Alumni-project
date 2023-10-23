<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;
    protected $table='texts';
    protected $fileable =[
         'serial',
         'babu',
         'text1',
         'text2',
         'text3',
         'text4',
         'text5',
         'text6',
         'text7',
         'text8',
         'text9',
         'text10',
       
    ];
}
