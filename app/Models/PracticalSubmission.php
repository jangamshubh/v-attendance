<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticalSubmission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'practical_submissions';
    protected $fillable = ['answer','file_link','student_id','assignment_id','obtained_marks','marks_added_at','answer_added_at','teacher_comments'];

    public function practical_submission_get_students() {
        return $this->belongsTo('App\Models\User', 'student_id');
    }

    public function practical_submission_get_practicals() {
        return $this->belongsTo('App\Models\Practical','practical_id');
    }
}
