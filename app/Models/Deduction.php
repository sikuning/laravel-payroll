<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $table = 'deduction';

    protected $fillable = [
        'deduction_name',
        'deduction_type',
        'percentage_of_basic',
        'limit_per_month',
    ];
}
