<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'member_card',
        'category_id',
        'phone',
        'degree_category',
        'gender',
        'blood',
        'country',
        'city',
        'occupation',
        'organization',
        'designation',
        'affiliation',
        'training',
        'expertise',
    ];

}
