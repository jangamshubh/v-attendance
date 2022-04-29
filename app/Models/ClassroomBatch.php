<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassroomBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classroom_batch';
    protected $fillable = ['classroom_id','batch_id','admin_id'];

    public function classroom_batch_get_classrooms() {
        return $this->belongsTo('App\Models\Classroom','classroom_id');
    }

    public function classroom_batch_get_batches() {
        return $this->belongsTo('App\Models\Batch','batch_id');
    }
}
