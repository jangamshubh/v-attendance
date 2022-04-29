<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchTeacherSubject extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'batch_teacher_subject';
    protected $fillable = ['batch_id','teacher_id','subject_id'];
}
