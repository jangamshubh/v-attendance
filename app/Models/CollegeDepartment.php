<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollegeDepartment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'college_department';
    protected $fillable = ['college_id','department_id','admin_id'];
}
