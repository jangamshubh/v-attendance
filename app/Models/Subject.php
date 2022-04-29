<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subjects';
    protected $fillable = ['name','code'];

    public function attendance_get_subjects() {
        return $this->hasMany('App\Models\Attendance','subject_id');
    }
    public function assignment_get_subjects() {
        return $this->hasMany('App\Models\Assignment','subject_id');
    }

    public function practical_get_subjects() {
        return $this->hasMany('App\Models\Practical','subject_id');
    }

    public function activity_get_subjects() {
        return $this->hasMany('App\Models\SpecialActivity','subject_id');
    }
}
