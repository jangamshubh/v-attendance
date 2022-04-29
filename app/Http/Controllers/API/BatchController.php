<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BatchService;

class BatchController extends Controller
{
    public function index() {
        $service = new BatchService;
        $batches = $service->getAllBatches();

        if ($batches) {
            return response()->json([
                'data' => $batches,
                'message' => 'Batches Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new BatchService;
        $batch = $service->createBatch($request);

        if ($batch) {
            return response()->json([
                'data' => $batch,
                'message' => 'Batch Created Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new BatchService;
        $batch = $service->editBatch($id);
        if ($batch) {
            return response()->json([
                'data' => $batch,
                'message' => 'Batch Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new BatchService;
        $batch = $service->updateBatch($request,$id);
        if ($batch) {
            return response()->json([
                'data' => $batch,
                'message' => 'Batch Updated Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id) {
        $service = new BatchService;
        $batch = $service->deleteBatch($id);

        if ($batch) {
            return response()->json([
                'data' => $batch,
                'message' => 'Batch Deleted Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id) {
        $service = new BatchService;
        $batch = $service->showBatch($id);

        if ($batch) {
            return response()->json([
                'data' => $batch,
                'message' => 'Batch Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
