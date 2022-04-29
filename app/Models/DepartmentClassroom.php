<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentClassroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'department_classroom';
    protected $fillable = ['department_id','classroom_id','admin_id'];
}
