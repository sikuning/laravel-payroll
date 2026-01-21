<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
    use HasFactory;

    protected $table = 'work_shift';

    protected $fillable = [
        'work_shift',
        'start_time',
        'end_time',
        'late_count_time',
    ];
}
