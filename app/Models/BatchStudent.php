<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'batch_student';
    protected $fillable = ['batch_id','student_id'];
}
