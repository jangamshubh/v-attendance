<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SpecialActivityGroupMember extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'special_activity_group_members';
    protected $fillable = ['special_activity_group_id','student_id','added_by','status'];
}
