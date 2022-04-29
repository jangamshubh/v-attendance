<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classrooms';
    protected $fillable = ['name','admin_id'];


    public function classroom_batch_get_classrooms() {
        return $this->hasMany('App\Models\ClassroomBatch','classroom_id');
    }
}
