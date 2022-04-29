<?php

namespace App\Services;

use App\Models\Assignment;
use Auth;
use App\Models\Classroom;
use Carbon\Carbon;
use App\Models\BatchTeacherSubject;
use App\Models\AssignmentBatch;
use App\Models\BatchStudent;
use App\Models\Subject;
use App\Models\ClassroomBatch;
use App\Models\Batch;

class BatchTeacherSubjectService {

    public function getTeacherSubjects() {
        if(Auth::user()->hasRole('Teacher')) {
            $subject_ids = BatchTeacherSubject::where('teacher_id',Auth::id())->pluck('subject_id')->toArray();
            $subjects = Subject::whereIn('id',$subject_ids)->get();
            return $this->successMessage($subjects);
        } else {
            return $this->errorRoleMessage();
        }
    }

    public function getTeacherClassrooms($subject_id) {
        if(Auth::user()->hasRole('Teacher')) {
            $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->where('subject_id',$subject_id)->pluck('batch_id')->toArray();
            $classroom_ids = ClassroomBatch::whereIn('batch_id',$batches)->pluck('classroom_id')->toArray();
            $classrooms = Classroom::whereIn('id',$classroom_ids)->get();
            return $this->successMessage($classrooms);
        } else {
            return $this->errorRoleMessage();
        }
    }

    public function getTeacherBatches($classroom_id) {
        if(Auth::user()->hasRole('Teacher')) {
            $batch_ids = ClassroomBatch::where('classroom_id',$classroom_id)->pluck('batch_id')->toArray();
            $batches = Batch::whereIn('id',$batch_ids)->get();
            return $this->successMessage($batches);
        } else {
            return $this->errorRoleMessage();
        }
    }

    protected function errorRoleMessage() {
        $message['status'] = 'error';
        $message['message'] = "You don't have the correct role to access this data";
        return $message;
    }

    protected function successMessage($data) {
        $message['status'] = 'success';
        $message['message'] = 'Data Retrieved Successfully';
        $message['data'] = $data;
        return $message;
    }
}
