<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $table = 'allowance';

    protected $fillable = [
        'allowance_name',
        'allowance_type',
        'percentage_of_basic',
        'limit_per_month',
    ];
}
