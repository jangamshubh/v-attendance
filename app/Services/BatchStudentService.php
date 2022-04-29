<?php

namespace App\Services;

use App\Models\Batch;
use Auth;
use App\Models\BatchStudent;
use App\Models\BatchTeacherSubject;
use App\Models\Subject;

class BatchStudentService {

    public function getAllStudentBatchSubjects() {
        if(Auth::user()->hasRole('Student')) {
            $batch_id = BatchStudent::where('student_id',Auth::id())->pluck('batch_id')->first();
            $subject_ids = BatchTeacherSubject::where('batch_id',$batch_id)->pluck('subject_id')->toArray();
            $subjects = Subject::whereIn('id',$subject_ids)->get();
            return $subjects;
        }
    }

}
