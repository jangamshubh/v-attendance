<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendances';

    protected $fillable = ['date','subject_id', 'start_time', 'end_time','added_by'];


    public function attendance_get_subjects() {
        return $this->belongsTo('App\Models\Subject','subject_id');
    }

    public function attendance_student_get_attendance() {
        return $this->hasMany('App\Models\AttendanceStudent','attendance_id');
    }
}
