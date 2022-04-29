<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialActivityBatch extends Model
{
    use HasFactory;

    protected $table = 'special_activity_batch';
    protected $fillable = ['special_activity_id','batch_id'];
}
