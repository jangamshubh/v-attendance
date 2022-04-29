<?php

namespace App\Services;

use App\Models\Batch;
use Auth;

class BatchService {

    public function getAllBatches() {
        if(Auth::user()->hasPermissionTo('View All Batches')) {
            $batches = Batch::all();
            return $batches;
        }
    }

    public function createBatch($request) {
        if(Auth::user()->hasPermissionTo('Create Batch')) {
            $batch = new Batch;
            $batch->create($request->all());
            return $batch;
        }
    }

    public function editBatch($id) {
        if(Auth::user()->hasPermissionTo('Edit Batch')) {
            $batch = Batch::find($id);
            return $batch;
        }
    }

    public function updateBatch($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Batch')) {
            $batch = Batch::find($id);
            $batch->name = $request->name;
            $batch->admin_id = $request->admin_id;
            $batch->classroom_id = $request->classroom_id;
            $batch->update();
            return $batch;
        }
    }

    public function showBatch($id) {
        if(Auth::user()->hasPermissionTo('Show Batch')) {
            $batch = Batch::find($id);
            return $batch;
        }
    }

    public function deleteBatch($id) {
        if(Auth::user()->hasPermissionTo('Delete Batch')) {
            $batch = Batch::find($id);
            $batch->delete();
            $batch = 'Deleted Successfully';
            return $batch;
        }
    }
}
