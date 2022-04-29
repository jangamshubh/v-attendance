<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendance_student';

    protected $fillable = ['attendance_id','student_id','status'];


    public function attendance_student_get_students() {
        return $this->belongsTo('App\Models\User', 'student_id');
    }

    public function attendance_student_get_attendance() {
        return $this->belongsTo('App\Models\Attendance','attendance_id');
    }
}
