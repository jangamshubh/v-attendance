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

class PracticalService {
    public function getAllPracticals() {
        if(Auth::user()->hasPermissionTo('Get Individual Teacher Practicals')) {
            $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->pluck('batch_id')->toArray();
            $practical_ids = PracticalBatch::whereIn('batch_id',$batches)->pluck('practical_id')->toArray();
            $practicals = Practical::whereIn('id',$practical_ids)->get();
            return $practicals;
        } elseif(Auth::user()->hasPermissionTo('Get Individual Student Practicals')) {
            $batches = BatchStudent::where('student_id',Auth::id())->pluck('batch_id')->toArray();
            $practical_ids = PracticalBatch::whereIn('batch_id',$batches)->pluck('practical_id')->toArray();
            $practicals = Practical::whereIn('id',$practical_ids)->get();
            return $practicals;
        }
    }

    public function storePractical($request) {
        if(Auth::user()->hasPermissionTo('Create Individual Teacher Practical')) {
            $practical = new Practical;
            $practical->name = $request->name;
            $practical->description = $request->description;
            $practical->rubric = $request->rubric;
            $practical->start_date_time = Carbon::parse($request->start_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
            $practical->end_date_time = Carbon::parse($request->end_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
            $practical->total_marks = $request->total_marks;
            $practical->allow_late_submision = $request->allow_late_submision;
            $practical->more_info_link = $request->more_info_link;
            $practical->added_by = Auth::id();
            $practical->subject_id = $request->subject_id;
            $practical->visibility = $request->visibility;
            if(Carbon::parse($request->start_date_time) <= Carbon::parse($request->end_date_time)) {
                $practical->save();
                if($request->add_for_all_classrooms == 0) {
                    $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->where('subject_id',$request->subject_id)->get();
                    foreach($batches as $batch) {
                        $practical_classroom_batch = new PracticalBatch;
                        $practical_classroom_batch->practical_id = $practical->id;
                        $practical_classroom_batch->batch_id = $batch->batch_id;
                        $practical_classroom_batch->save();
                    }
                    return $practical;
                } elseif($request->add_for_all_classrooms == 1) {
                    $batches = BatchTeacherSubject::where('teacher_id',Auth::id())->where('subject_id',$request->subject_id)->pluck('batch_id')->toArray();
                    $classroom_batches = ClassroomBatch::where('classroom_id',$request->classroom_id)->whereIn('batch_id',$batches)->pluck('batch_id')->toArray();
                    for ($i = 0; $i < count($classroom_batches); $i++) {
                        $practical_classroom_batch = new PracticalBatch;
                        $practical_classroom_batch->practical_id = $practical->id;
                        $practical_classroom_batch->batch_id = $classroom_batches[$i];
                        $practical_classroom_batch->save();
                    }
                    return $practical;
                } elseif ($request->add_for_all_classrooms == 2) {
                    $practical_classroom_batch = new PracticalBatch;
                    $practical_classroom_batch->practical_id = $practical->id;
                    $practical_classroom_batch->batch_id = $request->batch_id;
                    $practical_classroom_batch->save();
                    return $practical;
                }
            }
        }
    }


    public function editPractical($id) {
        if(Auth::user()->hasPermissionTo('Edit Individual Teacher Practical')) {
            $practical = Practical::find($id);
            if(Auth::id() == $practical->added_by) {
                $practical->start_date_time = Carbon::parse($practical->start_date_time)->format('m/d/Y H:i');
                $practical->end_date_time = Carbon::parse($practical->end_date_time)->format('m/d/Y H:i');
                return $practical;
            }
        }
    }

    public function updatePractical($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Individual Teacher Practical')) {
            $practical = Practical::find($id);
            if(Auth::id() == $practical->added_by) {
                $data = $this->teacherUpdate($request,$practical);
                return $data;
            }
        }
    }

    public function deletePractical($id) {
        if(Auth::user()->hasPermissionTo('Delete Individual Teacher Practical')) {
            $practical = Practical::find($id);
            if(Auth::id() == $practical->added_by) {
                $practical->delete();
                $practical = 'Deleted Successfully';
                return $practical;
            }
        }
    }

    public function showPractical($id) {
        if(Auth::user()->hasPermissionTo('View Individual Teacher Practical')) {
            $practical = Practical::where('id',$id)->with('practical_get_subjects','practical_get_teachers')->first();
            if(Auth::id() == $practical->added_by) {
                $batch_ids = PracticalBatch::where('practical_id',$id)->pluck('batch_id')->toArray();
                $batches = ClassroomBatch::whereIn('batch_id',$batch_ids)->with('classroom_batch_get_classrooms','classroom_batch_get_batches')->get();
                $array[0] = $practical;
                $array[1] = $batches;
                return $array;
            }
        } elseif(Auth::user()->hasPermissionTo('View Individual Student Practical')) {
            $batch_ids = PracticalBatch::where('practical_id',$id)->pluck('batch_id')->toArray();
            $check = BatchStudent::whereIn('batch_id',$batch_ids)->where('student_id',Auth::id())->count();
            if($check != 0) {
                $practical = Practical::where('id',$id)->with('practical_get_subjects','practical_get_teachers')->first();
                $batches = ClassroomBatch::whereIn('batch_id',$batch_ids)->with('classroom_batch_get_classrooms','classroom_batch_get_batches')->get();
                $array[0] = $practical;
                $array[1] = $batches;
                return $array;
            }
        }
    }

    private function teacherUpdate($request,$practical) {
        if(Carbon::parse($request->start_date_time) <= Carbon::parse($request->end_date_time)) {
            $practical->name = $request->name;
            $practical->description = $request->description;
            $practical->rubric = $request->rubric;
            $practical->start_date_time = Carbon::parse($request->start_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
            $practical->end_date_time = Carbon::parse($request->end_date_time)->timezone('Asia/Kolkata')->format('d-m-Y H:i');
            $practical->total_marks = $request->total_marks;
            $practical->allow_late_submision = $request->allow_late_submision;
            $practical->more_info_link = $request->more_info_link;
            $practical->visibility = $request->visibility;
            $practical->update();
            return $practical;
        }
    }

}
