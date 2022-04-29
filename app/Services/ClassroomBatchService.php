<?php

namespace App\Services;

use App\Models\ClassroomBatch;
use Auth;

class ClassroomBatchService {
    public function getAllClassroomBatches($department_id) {
        if(Auth::user()->hasPermissionTo('View All Classroom Batches')) {
            $batches = ClassroomBatch::where('department_id',$department_id)->get();
            return $batches;
        }
    }

    public function createClassroomBatch($request) {
        if(Auth::user()->hasPermissionTo('Create Classroom Batch')) {
            $batch = ClassroomBatch::create($request->all());
            return $batch;
        }
    }

    public function editClassroomBatch($id) {
        if(Auth::user()->hasPermissionTo('Edit Classroom Batch')) {
            $batch = ClassroomBatch::find($id);
            return $batch;
        }
    }

    public function updateClassroomBatch($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Classroom Batch')) {
            $batch = ClassroomBatch::find($id);
            $batch->classroom_id = $request->classroom_id;
            $batch->batch_id = $request->batch_id;
            $batch->admin_id = $request->admin_id;
            $batch->update();
            return $batch;
        }
    }

    public function deleteClassroomBatch($id) {
        if(Auth::user()->hasPermissionTo('Delete Classroom Batch')) {
            $batch = ClassroomBatch::find($id);
            $batch->delete();
        }
    }
}
