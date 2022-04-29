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

class AssignmentService {
    public function getAllAssignments() {
        if(Auth::user()->hasPermissionTo('Get All Assignments')) {
            if(Auth::user()->hasRole('Teacher')) {
                $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->pluck('batch_id')->toArray();
                $assignment_ids = AssignmentBatch::whereIn('batch_id',$batches)->pluck('assignment_id')->toArray();
                $data = Assignment::whereIn('id',$assignment_ids)->get();
                return $this->successMessage($data);
            } elseif(Auth::user()->hasRole('Student')) {
                $batches = BatchStudent::where('student_id',Auth::id())->pluck('batch_id')->toArray();
                $assignment_ids = AssignmentBatch::whereIn('batch_id',$batches)->pluck('assignment_id')->toArray();
                $data = Assignment::whereIn('id',$assignment_ids)->get();
                return $this->successMessage($data);
            } else {
                return $this->errorMessage();
            }
        } else {
            return $this->errorMessage();
        }
    }


    public function storeAssignment($request) {
        if(Auth::user()->hasPermissionTo('Create Assignment')) {
            if(Auth::user()->hasRole('Teacher')) {
                $assignment = new Assignment;
                $assignment->name = $request->name;
                $assignment->description = $request->description;
                $assignment->rubric = $request->rubric;
                $assignment->start_date_time = Carbon::parse($request->start_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                $assignment->end_date_time = Carbon::parse($request->end_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                $assignment->total_marks = $request->total_marks;
                $assignment->allow_late_submision = $request->allow_late_submision;
                $assignment->more_info_link = $request->more_info_link;
                $assignment->added_by = Auth::id();
                $assignment->subject_id = $request->subject_id;
                $assignment->visibility = $request->visibility;
                if(Carbon::parse($request->start_date_time) <= Carbon::parse($request->end_date_time)) {
                    $assignment->save();
                    if($request->add_for_all_classrooms == 0) {
                        $data = $this->add_for_all_classrooms_0($request,$assignment);
                        return $this->successCreateMessage($data);
                    } elseif($request->add_for_all_classrooms == 1) {
                        $data = $this->add_for_all_classrooms_1($request,$assignment);
                        return $this->successCreateMessage($data);
                    } elseif ($request->add_for_all_classrooms == 2) {
                        $data = $this->add_for_all_classrooms_2($request,$assignment);
                        return $this->successCreateMessage($data);
                    } else {
                        return $this->errorMessage();
                    }
                } else {
                    return $this->errorDeadlineMessage();
                }
            } else {
                return $this->errorRoleMessage();
            }
        }
    }

    protected function add_for_all_classrooms_0 ($request,$assignment) {
        $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->where('subject_id',$request->subject_id)->get();
        foreach($batches as $batch) {
            $assignment_classroom_batch = new AssignmentBatch;
            $assignment_classroom_batch->assignment_id = $assignment->id;
            $assignment_classroom_batch->batch_id = $batch->batch_id;
            $assignment_classroom_batch->save();
        }
        return $assignment;
    }

    protected function add_for_all_classrooms_1($request,$assignment) {
        $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->where('subject_id',$request->subject_id)->pluck('batch_id')->toArray();
        $classroom_batches = ClassroomBatch::where('classroom_id',$request->classroom_id)->whereIn('batch_id',$batches)->pluck('batch_id')->toArray();
        for ($i = 0; $i < count($classroom_batches); $i++) {
            $assignment_classroom_batch = new AssignmentBatch;
            $assignment_classroom_batch->assignment_id = $assignment->id;
            $assignment_classroom_batch->batch_id = $classroom_batches[$i];
            $assignment_classroom_batch->save();
        }
        return $assignment;
    }

    protected function add_for_all_classrooms_2($request,$assignment) {
        $assignment_classroom_batch = new AssignmentBatch;
        $assignment_classroom_batch->assignment_id = $assignment->id;
        $assignment_classroom_batch->batch_id = $request->batch_id;
        $assignment_classroom_batch->save();
        return $assignment;
    }

    public function editAssignment($id) {
        if(Auth::user()->hasPermissionTo('Edit Assignment')) {
            if(Auth::user()->hasRole('Teacher')) {
                $assignment = Assignment::find($id);
                if(Auth::id() == $assignment->added_by) {
                    $assignment->start_date_time = Carbon::parse($assignment->start_date_time)->format('m/d/Y H:i');
                    $assignment->end_date_time = Carbon::parse($assignment->end_date_time)->format('m/d/Y H:i');
                    return $this->successMessage($assignment);
                } else {
                    return $this->errorAddedByMessage();
                }
            } else {
                return $this->errorRoleMessage();
            }
        }
    }

    public function updateAssignment($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Assignment')) {
            if(Auth::user()->hasRole('Teacher')) {
                $assignment = Assignment::find($id);
                if(Auth::id() == $assignment->added_by) {
                    if(Carbon::parse($request->start_date_time) <= Carbon::parse($request->end_date_time)) {
                        $assignment->name = $request->name;
                        $assignment->description = $request->description;
                        $assignment->rubric = $request->rubric;
                        $assignment->start_date_time = Carbon::parse($request->start_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                        $assignment->end_date_time = Carbon::parse($request->end_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                        $assignment->total_marks = $request->total_marks;
                        $assignment->allow_late_submision = $request->allow_late_submision;
                        $assignment->more_info_link = $request->more_info_link;
                        $assignment->visibility = $request->visibility;
                        $assignment->update();
                        return $this->successUpdateMessage($assignment);
                    } else {
                        return $this->errorDeadlineMessage();
                    }
                } else {
                    return $this->errorAddedByMessage();
                }
            } else {
                return $this->errorRoleMessage();
            }
        }
    }

    public function deleteAssignment($id) {
        if(Auth::user()->hasPermissionTo('Delete Assignment')) {
            if(Auth::user()->hasRole('Teacher')) {
                $assignment = Assignment::find($id);
                if(Auth::id() == $assignment->added_by) {
                    $assignment->delete();
                    return $this->successDeleteMessage();
                } else {
                    return $this->errorAddedByMessage();
                }
            } else {
                return $this->errorRoleMessage();
            }
        }
    }

    public function showAssignment($id) {
        if(Auth::user()->hasPermissionTo('View Assignment')) {
            if(Auth::user()->hasRole('Teacher')) {
                $assignment = Assignment::where('id',$id)->with('assignment_get_subjects','assignment_get_teachers')->first();
                if(Auth::id() == $assignment->added_by) {
                    $batch_ids = AssignmentBatch::where('assignment_id',$id)->pluck('batch_id')->toArray();
                    $batches = ClassroomBatch::whereIn('batch_id',$batch_ids)->with('classroom_batch_get_classrooms','classroom_batch_get_batches')->get();
                    $data['assignment'] = $assignment;
                    $data['batches'] = $batches;
                    return $this->successShowMessage($data);
                } else {
                    return $this->errorAddedByMessage();
                }
            } elseif(Auth::user()->hasRole('Student')) {
                $batch_ids = AssignmentBatch::where('assignment_id',$id)->pluck('batch_id')->toArray();
                $check = BatchStudent::whereIn('batch_id',$batch_ids)->where('student_id',Auth::id())->count();
                if($check != 0) {
                    $assignment = Assignment::where('id',$id)->with('assignment_get_subjects','assignment_get_teachers')->first();
                    $batches = ClassroomBatch::whereIn('batch_id',$batch_ids)->with('classroom_batch_get_classrooms','classroom_batch_get_batches')->get();
                    $data['assignment'] = $assignment;
                    $data['batches'] = $batches;
                    return $this->successShowMessage($data);
                } else {
                    return $this->errorMessage();
                }
            } else {
                return $this->errorRoleMessage();
            }
        } else {
            return $this->errorMessage();
        }
    }



    protected function successShowMessage($data) {
        $assignment['assignment'] = $data['assignment'];
        $assignment['batches'] = $data['batches'];
        $assignment['status'] = 'success';
        $assignment['message'] = 'Assignment Retrieved Successfully';
        return $assignment;
    }

    protected function successDeleteMessage() {
        $assignment['status'] = 'success';
        $assignment['message'] = 'Assignment Deleted Successfully';
        return $assignment;
    }

    protected function successMessage($data) {
        $assignments['status'] = 'success';
        $assignments['message'] = 'Assignments Retrieved Successfully';
        $assignments['data'] = $data;
        return $assignments;
    }

    protected function successCreateMessage($data) {
        $assignment['status'] = 'success';
        $assignment['message'] = 'Assignment Created Successfully';
        $assignment['data'] = $data;
        return $assignment;
    }

    protected function successUpdateMessage($data) {
        $assignment['status'] = 'success';
        $assignment['message'] = 'Assignment Updated Successfully';
        $assignment['data'] = $data;
        return $assignment;
    }

    protected function errorMessage() {
        $assignments['status'] = 'error';
        $assignments['message'] = 'You are not allowed to access this data';
        return $assignments;
    }

    protected function errorDeadlineMessage() {
        $assignments['status'] = 'error';
        $assignments['message'] = 'You have kept End Time Before the Start Time, Please ensure deadline is after the Start Time';
        return $assignments;
    }

    protected function errorRoleMessage() {
        $assignments['status'] = 'error';
        $assignments['message'] = "You don't have the correct role to access this data";
        return $assignments;
    }

    protected function errorAddedByMessage() {
        $assignments['status'] = 'error';
        $assignments['message'] = "You haven't added this assignment, hence cannot edit it";
        return $assignments;
    }

}
