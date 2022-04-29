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
use App\Models\AssignmentSubmission;

class AssignmentSubmissionService {

    public function getAllSubmissions($assignment_id) {
        if(Auth::user()->hasPermissionTo('Get All Submissions')) {
            if(Auth::user()->hasRole('Teacher')) {
                $assignment = Assignment::find($assignment_id);
                if($assignment->added_by == Auth::id()) {
                    $submissions = AssignmentSubmission::where('assignment_id',$assignment_id)->with('assignment_submission_get_students','assignment_submission_get_assignments')->get();
                    return $this->retrieveSuccessMessage($submissions);
                } else {
                    return $this->addedByErrorMessage();
                }
            } elseif(Auth::user()->hasRole('Student')) {
                $submissions = AssignmentSubmission::where('assignment_id',$assignment_id)->where('student_id',Auth::id())->with('assignment_submission_get_students','assignment_submission_get_assignments')->get();
                return $this->retrieveSuccessMessage($submissions);
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function addSubmission($request,$assignment_id) {
        if(Auth::user()->hasPermissionTo('Add Submission')) {
            $assignment = Assignment::find($assignment_id);
            $deadline = Carbon::parse($assignment->end_date_time);
            $batches = AssignmentBatch::where('assignment_id',$assignment_id)->pluck('batch_id')->toArray();
            $count = BatchStudent::whereIn('batch_id',$batches)->where('student_id',Auth::id())->count();
            $current_time = Carbon::now();
            if($count > 0 ) {
                if(($assignment->allow_late_submision == 0) && ($current_time->lte($deadline))) {
                    return $this->createSubmission($request,$assignment_id);
                } elseif($assignment->allow_late_submision == 1) {
                    return $this->createSubmission($request,$assignment_id);
                } else {
                    return $this->deadlineErrorMessage();
                }
            } else {
                return $this->alreadySubmittedErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function checkTime($assignment_id) {
        if(Auth::user()->hasPermissionTo('Add Submission')) {
            $assignment = Assignment::find($assignment_id);
            $deadline = Carbon::parse($assignment->end_date_time);
            $current_time = Carbon::now('Asia/Kolkata');
            if ($current_time->lte($deadline) && $assignment->allow_late_submision == 0) {
                return $this->retrieveSuccessMessage($assignment);
            } else if($assignment->allow_late_submision == 1) {
                return $this->retrieveSuccessMessage($assignment);
            } else {
                return $this->deadlineErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function checkSubmissionPermission($assignment_id) {
        if(Auth::user()->hasPermissionTo('Add Submission')) {
            $assignment = Assignment::find($assignment_id);
            $batches = AssignmentBatch::where('assignment_id',$assignment_id)->pluck('batch_id')->toArray();
            $count = BatchStudent::whereIn('batch_id',$batches)->where('student_id',Auth::id())->count();
            $submissions = AssignmentSubmission::where('assignment_id',$assignment_id)->where('student_id',Auth::id())->count();
            if ($count > 0) {
                if($submissions == 0) {
                    return $this->retrieveSuccessMessage($assignment);
                } else {
                    return $this->alreadySubmittedErrorMessage();
                }
            } else {
                return $this->batchErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function addMarks($request,$assignment_id,$id) {
        if(Auth::user()->hasPermissionTo('Add Marks')) {
            $assignment = Assignment::find($assignment_id);
            if($assignment->added_by == Auth::id()) {
                $submission = AssignmentSubmission::find($id);
                $submission->obtained_marks = $request->obtained_marks;
                $submission->teacher_comments = $request->teacher_comments;
                $submission->marks_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
                $submission->save();
                return $this->addMarksSuccessMessage($submission);
            } else {
                return $this->addedByErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function checkAddMarksPermission($assignment_id) {
        if(Auth::user()->hasPermissionTo('Add Marks')) {
            $assignment = Assignment::find($assignment_id);
            if($assignment->added_by == Auth::id()) {
                return $this->retrieveSuccessMessage($assignment);
            } else {
                return $this->addedByErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function showSubmission($assignment_id,$id) {
        if(Auth::user()->hasPermissionTo('View Submission')) {
            if(Auth::user()->hasRole('Teacher')) {
                $assignment = Assignment::find($assignment_id);
                if($assignment->added_by == Auth::id()) {
                    $submission = AssignmentSubmission::where('id',$id)->with('assignment_submission_get_students','assignment_submission_get_assignments')->first();
                    return $this->retrieveSuccessMessage($submission);
                } else {
                    return $this->addedByErrorMessage();
                }
            } elseif(Auth::user()->hasRole('Student')) {
                $submission = AssignmentSubmission::where('id',$id)->with('assignment_submission_get_students','assignment_submission_get_assignments')->first();
                if($submission->student_id == Auth::id()) {
                    return $this->retrieveSuccessMessage($submission);
                } else {
                    return $this->addedByStudentErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function autoEvaluate($request,$assignment_id) {
        if(Auth::user()->hasPermissionTo('Add Marks')) {
            $assignment = Assignment::find($assignment_id);
            if($assignment->added_by == Auth::id()) {
                $deadline = Carbon::parse($assignment->end_date_time);
                $submission_array = AssignmentSubmission::where('assignment_id',$assignment_id)->where('obtained_marks',null)->pluck('id')->toArray();
                for($i = 0; $i < count($submission_array); $i++) {
                    $submission = AssignmentSubmission::find($submission_array[$i]);
                    $submission_time = Carbon::parse($submission->answer_added_at);
                    if($submission_time->lte($deadline)) {
                        $data = $this->autoEvaluateBeforeDeadline($request,$submission);
                    } elseif($submission_time->gt($deadline)) {
                        $data = $this->autoEvaluateAfterDeadline($request,$submission);
                    } else {
                        return $this->contactAdminErrorMessage();
                    }
                }
                return $this->retrieveSuccessMessage($assignment);
            } else {
                return $this->addedByErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    protected function autoEvaluateBeforeDeadline($request,$submission) {
        $submission->obtained_marks = $request->submission_marks_before_deadline;
        $submission->teacher_comments = $request->submission_comments_before_deadline;
        $submission->marks_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
        $submission->is_auto_evaluated = 1;
        $submission->update();
    }

    protected function autoEvaluateAfterDeadline($request,$submission) {
        $submission->obtained_marks = $request->submission_marks_after_deadline;
        $submission->teacher_comments = $request->submission_comments_after_deadline;
        $submission->marks_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
        $submission->is_auto_evaluated = 1;
        $submission->update();
    }
    protected function addedByErrorMessage() {
        $submissions['status'] = 'error';
        $submissions['message'] = "You haven't added this assignment, hence cannot view the submissions it";
        return $submissions;
    }

    protected function addedByStudentErrorMessage() {
        $submissions['status'] = 'error';
        $submissions['message'] = "You haven't added this submission, hence cannot view it";
        return $submissions;
    }

    protected function retrieveSuccessMessage($data) {
        $submissions['status'] = 'success';
        $submissions['message'] = "Submission Retrieved Successfully";
        $submissions['data'] = $data;
        return $submissions;
    }

    protected function roleErrorMessage() {
        $submissions['status'] = 'error';
        $submissions['message'] = "You don't have the correct role to access this data";
        return $submissions;
    }

    protected function alreadySubmittedErrorMessage() {
        $submissions['status'] = 'error';
        $submissions['message'] = "You have already submitted the submission!";
        return $submissions;
    }

    protected function createSubmission($request,$assignment_id) {
        $submission = new AssignmentSubmission;
        $submission->answer = $request->answer;
        $submission->student_id = Auth::id();
        $submission->file_link = $request->file_link;
        $submission->assignment_id = $assignment_id;
        $submission->answer_added_at = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
        $submission->save();
        $data['status'] = 'success';
        $data['message'] = 'Submission Saved Successfully';
        $data['data'] = $submission;
        return $data;
    }

    protected function batchErrorMessage() {
        $submissions['status'] = 'error';
        $submissions['message'] = "This Assignment is not added for your Batch!";
        return $submissions;
    }

    protected function addMarksSuccessMessage($data) {
        $submissions['status'] = 'success';
        $submissions['message'] = "Marks added Successfully!";
        $submissions['data'] = $data;
        return $submissions;
    }

    protected function contactAdminErrorMessage() {
        $submissions['status'] = 'error';
        $submissions['message'] = "Contact the Admin!";
        return $submissions;
    }

    protected function deadlineErrorMessage() {
        $submissions['status'] = 'error';
        $submissions['message'] = "Deadline has already passed!";
        return $submissions;
    }
}
