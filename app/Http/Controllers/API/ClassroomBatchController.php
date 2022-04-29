<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClassroomBatchService;

class ClassroomBatchController extends Controller
{
    public function index($classroom_id) {
        $service = new ClassroomBatchService;
        $batches = $service->getAllClassroomBatches($classroom_id);
        if ($batches) {
            return response()->json([
                'data' => $batches,
                'status' => 'Success',
                'message' => 'College Departments Retrieved Successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new ClassroomBatchService;
        $batch = $service->createClassroomBatch($request);
        if ($batch) {
            return response()->json([
                'data' => $batch,
                'status' => 'Success',
                'message' => 'Department & Classroom Attached Successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new ClassroomBatchService;
        $batch = $service->editClassroomBatch($id);
        if ($batch) {
            return response()->json([
                'data' => $batch,
                'status' => 'Success',
                'message' => 'Data Retrieved Successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new ClassroomBatchService;
        $batch = $service->updateClassroomBatch($request,$id);
        if ($batch) {
            return response()->json([
                'data' => $batch,
                'status' => 'Success',
                'message' => 'Data Updated Successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id) {
        $service = new ClassroomBatchService;
        $batch = $service->deleteClassroomBatch($id);
        if ($batch) {
            return response()->json([
                'data' => $batch,
                'status' => 'Success',
                'message' => 'Data Retrieved Successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
