<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendance_batch';

    protected $fillable = ['attendance_id','batch_id'];


    public function attendance_batch_get_batches() {
        return $this->belongsTo('App\Models\Batch','batch_id');
    }
}
