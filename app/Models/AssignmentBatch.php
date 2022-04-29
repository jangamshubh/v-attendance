<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignmentBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'assignment_batch';
    protected $fillable = ['assignment_id','batch_id'];
}
