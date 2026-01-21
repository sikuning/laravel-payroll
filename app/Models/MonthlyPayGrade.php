<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayGrade extends Model
{
    use HasFactory;

    protected $table = 'monthly_pay_grade';

    protected $fillable = [
        'monthly_pay_name',
       	'gross_salary',
        'percentage_of_basic',
        'basic_salary',
        'overtime_rate',
        'allowance',
        'deduction',
    ];
}
