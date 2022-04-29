<?php

namespace App\Services;

use Auth;
use App\Models\SpecialActivity;
use App\Models\SpecialActivityBatch;
use App\Models\Classroom;
use Carbon\Carbon;
use App\Models\BatchTeacherSubject;
use App\Models\BatchStudent;
use App\Models\Subject;
use App\Models\ClassroomBatch;
use App\Models\Batch;

class SpecialActivityService {

    public function getAllActivities() {
        if(Auth::user()->hasPermissionTo('Get All Activities')) {
            if(Auth::user()->hasRole('Teacher')) {
                $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->pluck('batch_id')->toArray();
                $activity_ids = SpecialActivityBatch::whereIn('batch_id',$batches)->pluck('special_activity_id')->toArray();
                $data = SpecialActivity::whereIn('id',$activity_ids)->get();
                return $this->successMessage($data);
            } elseif(Auth::user()->hasRole('Student')) {
                $batches = BatchStudent::where('student_id',Auth::id())->pluck('batch_id')->toArray();
                $activity_ids = SpecialActivityBatch::whereIn('batch_id',$batches)->pluck('special_activity_id')->toArray();
                $data = SpecialActivity::whereIn('id',$activity_ids)->get();
                return $this->successMessage($data);
            } else {
                return $this->errorMessage();
            }
        } else {
            return $this->errorMessage();
        }
    }


    public function storeSpecialActivity($request) {
        if(Auth::user()->hasPermissionTo('Create Activity')) {
            if(Auth::user()->hasRole('Teacher')) {
                $activity = new SpecialActivity;
                $activity->name = $request->name;
                $activity->description = $request->description;
                $activity->rubric = $request->rubric;
                $activity->start_date_time = Carbon::parse($request->start_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                $activity->end_date_time = Carbon::parse($request->end_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                $activity->total_marks = $request->total_marks;
                $activity->allow_late_submision = $request->allow_late_submision;
                $activity->more_info_link = $request->more_info_link;
                $activity->added_by = Auth::id();
                $activity->subject_id = $request->subject_id;
                $activity->visibility = $request->visibility;
                $activity->group_limit = $request->group_limit;
                if(Carbon::parse($request->start_date_time) <= Carbon::parse($request->end_date_time)) {
                    $activity->save();
                    if($request->add_for_all_classrooms == 0) {
                        $data = $this->add_for_all_classrooms_0($request,$activity);
                        return $this->successCreateMessage($data);
                    } elseif($request->add_for_all_classrooms == 1) {
                        $data = $this->add_for_all_classrooms_1($request,$activity);
                        return $this->successCreateMessage($data);
                    } elseif ($request->add_for_all_classrooms == 2) {
                        $data = $this->add_for_all_classrooms_2($request,$activity);
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

    protected function add_for_all_classrooms_0 ($request,$activity) {
        $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->where('subject_id',$request->subject_id)->get();
        foreach($batches as $batch) {
            $activity_classroom_batch = new SpecialActivityBatch;
            $activity_classroom_batch->special_activity_id = $activity->id;
            $activity_classroom_batch->batch_id = $batch->batch_id;
            $activity_classroom_batch->save();
        }
        return $activity;
    }

    protected function add_for_all_classrooms_1($request,$activity) {
        $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->where('subject_id',$request->subject_id)->pluck('batch_id')->toArray();
        $classroom_batches = ClassroomBatch::where('classroom_id',$request->classroom_id)->whereIn('batch_id',$batches)->pluck('batch_id')->toArray();
        for ($i = 0; $i < count($classroom_batches); $i++) {
            $activity_classroom_batch = new SpecialActivityBatch;
            $activity_classroom_batch->special_activity_id = $activity->id;
            $activity_classroom_batch->batch_id = $classroom_batches[$i];
            $activity_classroom_batch->save();
        }
        return $activity;
    }

    protected function add_for_all_classrooms_2($request,$activity) {
        $activity_classroom_batch = new SpecialActivityBatch;
        $activity_classroom_batch->special_activity_id = $activity->id;
        $activity_classroom_batch->batch_id = $request->batch_id;
        $activity_classroom_batch->save();
        return $activity;
    }

    public function editSpecialActivity($id) {
        if(Auth::user()->hasPermissionTo('Edit Activity')) {
            if(Auth::user()->hasRole('Teacher')) {
                $activity = SpecialActivity::find($id);
                if(Auth::id() == $activity->added_by) {
                    $activity->start_date_time = Carbon::parse($activity->start_date_time)->format('m/d/Y H:i');
                    $activity->end_date_time = Carbon::parse($activity->end_date_time)->format('m/d/Y H:i');
                    return $this->successMessage($activity);
                } else {
                    return $this->errorAddedByMessage();
                }
            } else {
                return $this->errorRoleMessage();
            }
        }
    }

    public function updateSpecialActivity($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Activity')) {
            if(Auth::user()->hasRole('Teacher')) {
                $activity = SpecialActivity::find($id);
                if(Auth::id() == $activity->added_by) {
                    if(Carbon::parse($request->start_date_time) <= Carbon::parse($request->end_date_time)) {
                        $activity->name = $request->name;
                        $activity->description = $request->description;
                        $activity->rubric = $request->rubric;
                        $activity->start_date_time = Carbon::parse($request->start_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                        $activity->end_date_time = Carbon::parse($request->end_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
                        $activity->total_marks = $request->total_marks;
                        $activity->allow_late_submision = $request->allow_late_submision;
                        $activity->more_info_link = $request->more_info_link;
                        $activity->visibility = $request->visibility;
                        $activity->group_limit = $request->group_limit;
                        $activity->update();
                        return $this->successUpdateMessage($activity);
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

    public function deleteSpecialActivity($id) {
        if(Auth::user()->hasPermissionTo('Delete Activity')) {
            if(Auth::user()->hasRole('Teacher')) {
                $activity = SpecialActivity::find($id);
                if(Auth::id() == $activity->added_by) {
                    $activity->delete();
                    return $this->successDeleteMessage();
                } else {
                    return $this->errorAddedByMessage();
                }
            } else {
                return $this->errorRoleMessage();
            }
        }
    }

    public function showSpecialActivity($id) {
        if(Auth::user()->hasPermissionTo('View Activity')) {
            if(Auth::user()->hasRole('Teacher')) {
                $activity = SpecialActivity::where('id',$id)->with('activity_get_subjects','activity_get_teachers')->first();
                if(Auth::id() == $activity->added_by) {
                    $batch_ids = SpecialActivityBatch::where('special_activity_id',$id)->pluck('batch_id')->toArray();
                    $batches = ClassroomBatch::whereIn('batch_id',$batch_ids)->with('classroom_batch_get_classrooms','classroom_batch_get_batches')->get();
                    $data['activity'] = $activity;
                    $data['batches'] = $batches;
                    return $this->successShowMessage($data);
                } else {
                    return $this->errorAddedByMessage();
                }
            } elseif(Auth::user()->hasRole('Student')) {
                $batch_ids = SpecialActivityBatch::where('special_activity_id',$id)->pluck('batch_id')->toArray();
                $check = BatchStudent::whereIn('batch_id',$batch_ids)->where('student_id',Auth::id())->count();
                if($check != 0) {
                    $activity = SpecialActivity::where('id',$id)->with('activity_get_subjects','activity_get_teachers')->first();
                    $batches = ClassroomBatch::whereIn('batch_id',$batch_ids)->with('classroom_batch_get_classrooms','classroom_batch_get_batches')->get();
                    $data['activity'] = $activity;
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
        $activity['activity'] = $data['activity'];
        $activity['batches'] = $data['batches'];
        $activity['status'] = 'success';
        $activity['message'] = 'Special Activity Retrieved Successfully';
        return $activity;
    }

    protected function successDeleteMessage() {
        $activity['status'] = 'success';
        $activity['message'] = 'Special Activity Deleted Successfully';
        return $activity;
    }

    protected function successMessage($data) {
        $activity['status'] = 'success';
        $activity['message'] = 'Special Activity Retrieved Successfully';
        $activity['data'] = $data;
        return $activity;
    }

    protected function successCreateMessage($data) {
        $activity['status'] = 'success';
        $activity['message'] = 'Special Activity Created Successfully';
        $activity['data'] = $data;
        return $activity;
    }

    protected function successUpdateMessage($data) {
        $activity['status'] = 'success';
        $activity['message'] = 'Special Activity Updated Successfully';
        $activity['data'] = $data;
        return $activity;
    }

    protected function errorMessage() {
        $activity['status'] = 'error';
        $activity['message'] = 'You are not allowed to access this data';
        return $activity;
    }

    protected function errorDeadlineMessage() {
        $activity['status'] = 'error';
        $activity['message'] = 'You have kept End Time Before the Start Time, Please ensure deadline is after the Start Time';
        return $activity;
    }

    protected function errorRoleMessage() {
        $activity['status'] = 'error';
        $activity['message'] = "You don't have the correct role to access this data";
        return $activity;
    }

    protected function errorAddedByMessage() {
        $activity['status'] = 'error';
        $activity['message'] = "You haven't added this activity, hence cannot edit it";
        return $activity;
    }
}
