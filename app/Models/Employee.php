<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory; 

    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'department',
        'designation',
        'branch',
        'dob',
        'gender',
        'religion',
        'phone',
        'address',
        'contact',
        'date_of_joining',
        'date_of_leaving',
        'marital-status',
        'work_shift',
        'status',
        'email',
        'password',
    ];
}
