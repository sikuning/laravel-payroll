<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $fillable = ['employeeId','date','status','leaveType','halfDayType','application_status','applied_on','clock_in','clock_out','is_late','updated_by','created_at','updated_at'];
}
