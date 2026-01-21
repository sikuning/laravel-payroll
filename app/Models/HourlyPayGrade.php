<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlyPayGrade extends Model
{
    use HasFactory;

    protected $table = 'hourly_pay_grade';

    protected $fillable = [
        'hourly_pay_name',
        'hourly_rate',
    ];
}
