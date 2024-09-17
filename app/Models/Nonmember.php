<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nonmember extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'serial', 'admin_name', 'name', 'email', 'phone', 'category_id', 'profile_image', 'designation', 'amount', 'getway_fee', 'total_amount', 'tran_id', 'payment_status', 'passing_year', 'address', 'payment_type', 'payment_time', 'payment_method', 'payment_date', 'payment_year', 'payment_month', 'payment_day', 'web_link', 'bank_tran', 'problem_status', 'problem_update_time', 'problem_update_by', 'department', 'registration', 'resident', 'gender', 'registration_type', 'created_at', 'updated_at' 
    ];
}
