<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SpecialActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'special_activities';
    protected $fillable = ['name','description','total_marks','start_date_time','end_date_time','allow_late_submision','rubric','more_info_link','added_by','subject_id','visibility','group_limit'];


    public function activity_get_subjects() {
        return $this->belongsTo('App\Models\Subject','subject_id');
    }

    public function activity_get_teachers() {
        return $this->belongsTo('App\Models\User','added_by');
    }
}
