<?php

namespace App\Services;

use App\Models\Practical;
use Auth;
use App\Models\Classroom;
use Carbon\Carbon;
use App\Models\BatchTeacherSubject;
use App\Models\PracticalBatch;
use App\Models\BatchStudent;
use App\Models\Subject;
use App\Models\ClassroomBatch;
use App\Models\Batch;
use App\Models\PracticalSubmission;

class PracticalSubmissionService {

    public function getAllSubmissions($practical_id) {
        if(Auth::user()->hasPermissionTo('Get All Individual Submissions')) {
            $practical = Practical::find($practical_id);
            if($practical->added_by == Auth::id()) {
                $submissions = PracticalSubmission::where('practical_id',$practical_id)->with('practical_submission_get_students','practical_submission_get_practicals')->get();
                return $submissions;
            }
        } elseif(Auth::user()->hasPermissionTo('View Individual Student Submission')) {
            $submissions = PracticalSubmission::where('practical_id',$practical_id)->where('student_id',Auth::id())->with('practical_submission_get_students','practical_submission_get_practicals')->get();
            return $submissions;
        }
    }

    public function addSubmission($request,$practical_id) {
        if(Auth::user()->hasPermissionTo('Add Individual Student Submission')) {
            $practical = Practical::find($practical_id);
            $deadline = Carbon::parse($practical->end_date_time);
            $batches = PracticalBatch::where('practical_id',$practical_id)->pluck('batch_id')->toArray();
            $count = BatchStudent::whereIn('batch_id',$batches)->where('student_id',Auth::id())->count();
            $current_time = Carbon::now();
            if ((($current_time->lte($deadline)) && ($practical->allow_late_submision == 0)) && ($count > 0)) {
                $submission = new PracticalSubmission;
                $submission->answer = $request->answer;
                $submission->student_id = Auth::id();
                $submission->file_link = $request->file_link;
                $submission->practical_id = $practical_id;
                $submission->answer_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
                $submission->save();
                return $submission;
            } elseif(($practical->allow_late_submision == 1) && ($count > 0)) {
                $submission = new PracticalSubmission;
                $submission->answer = $request->answer;
                $submission->student_id = Auth::id();
                $submission->file_link = $request->file_link;
                $submission->practical_id = $practical_id;
                $submission->answer_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
                $submission->save();
                return $submission;
            }
        }
    }

    public function checkTime($practical_id) {
        if(Auth::user()->hasPermissionTo('Add Individual Student Submission')) {
            $practical = Practical::find($practical_id);
            $deadline = Carbon::parse($practical->end_date_time);
            $current_time = Carbon::now('Asia/Kolkata');
            if ($current_time->lte($deadline) && $practical->allow_late_submision == 0) {
                return $practical;
            } else if($practical->allow_late_submision == 1) {
                return $practical;
            }
        }
    }

    public function checkSubmissionPermission($practical_id) {
        if(Auth::user()->hasPermissionTo('Add Individual Student Submission')) {
            $practical = Practical::find($practical_id);
            $batches = PracticalBatch::where('practical_id',$practical_id)->pluck('batch_id')->toArray();
            $count = BatchStudent::whereIn('batch_id',$batches)->where('student_id',Auth::id())->count();
            $submissions = PracticalSubmission::where('practical_id',$practical_id)->where('student_id',Auth::id())->count();
            if ($count > 0 && $submissions == 0) {
                return $practical;
            }
        }
    }

    public function addMarks($request,$practical_id,$id) {
        if(Auth::user()->hasPermissionTo('Add Individual Submission Marks')) {
            $practical = Practical::find($practical_id);
            if($practical->added_by == Auth::id()) {
                $submission = PracticalSubmission::find($id);
                $submission->obtained_marks = $request->obtained_marks;
                $submission->teacher_comments = $request->teacher_comments;
                $submission->marks_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
                $submission->save();
                return $submission;
            }
        }
    }

    public function checkAddMarksPermission($practical_id) {
        if(Auth::user()->hasPermissionTo('Add Individual Submission Marks')) {
            $practical = Practical::find($practical_id);
            if($practical->added_by == Auth::id()) {
                return $practical;
            }
        }
    }

    public function showSubmission($practical_id,$id) {
        if(Auth::user()->hasPermissionTo('Get All Individual Submissions')) {
            $practical = Practical::find($practical_id);
            if($practical->added_by == Auth::id()) {
                $submission = PracticalSubmission::where('id',$id)->with('practical_submission_get_students','practical_submission_get_practicals')->first();
                return $submission;
            }
        } elseif(Auth::user()->hasPermissionTo('View Individual Student Submission')) {
            $submission = PracticalSubmission::where('id',$id)->with('practical_submission_get_students','practical_submission_get_practicals')->first();
            if($submission->student_id == Auth::id()) {
                return $submission;
            }
        }
    }

    public function autoEvaluate($request,$practical_id) {
        if(Auth::user()->hasPermissionTo('Add Individual Submission Marks')) {
            $practical = Practical::find($practical_id);
            if($practical->added_by == Auth::id()) {
                $deadline = Carbon::parse($practical->end_date_time);
                $submission_array = PracticalSubmission::where('practical_id',$practical_id)->where('obtained_marks',null)->pluck('id')->toArray();
                for($i = 0; $i < count($submission_array); $i++) {
                    $submission = PracticalSubmission::find($submission_array[$i]);
                    $submission_time = Carbon::parse($submission->answer_added_at);
                    if($submission_time->lte($deadline)) {
                        $submission->obtained_marks = $request->submission_marks_before_deadline;
                        $submission->teacher_comments = $request->submission_comments_before_deadline;
                        $submission->marks_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
                        $submission->is_auto_evaluated = 1;
                        $submission->update();
                    } elseif($submission_time->gt($deadline)) {
                        $submission->obtained_marks = $request->submission_marks_after_deadline;
                        $submission->teacher_comments = $request->submission_comments_after_deadline;
                        $submission->marks_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
                        $submission->is_auto_evaluated = 1;
                        $submission->update();
                    } else {

                    }
                }
                return $practical;
            }
        }
    }
}
