<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'batches';
    protected $fillable = ['name','admin_id','classroom_id'];


    public function attendance_batch_get_batches() {
        return $this->hasMany('App\Models\AttendanceBatch','batch_id');
    }

    public function classroom_batch_get_batches() {
        return $this->hasMany('App\Models\ClassroomBatch','batch_id');
    }
}
