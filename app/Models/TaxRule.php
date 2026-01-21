<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRule extends Model
{
    use HasFactory;

    protected $table = 'tax_rule';

    protected $fillable = [
        'total_income',
        'tax_rate',
        'taxable_amount',
        'gender',
    ];
}
