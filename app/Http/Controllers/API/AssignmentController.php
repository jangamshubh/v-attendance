<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AssignmentService;

class AssignmentController extends Controller
{
    public function index() {
        $service = new AssignmentService;
        $assignments = $service->getAllAssignments();
        if ($assignments['status'] == 'success') {
            return response()->json([
                'data' => $assignments['data'],
                'status' => $assignments['status'],
                'message' => $assignments['message'],
            ]);
        } else {
            return response()->json([
                'status' => $assignments['status'],
                'message' => $assignments['message'],
            ]);
        }
    }

    public function store(Request $request) {
        $service = new AssignmentService;
        $assignment = $service->storeAssignment($request);
        if ($assignment['status'] == 'success') {
            return response()->json([
                'data' => $assignment['data'],
                'status' => $assignment['status'],
                'message' => $assignment['message'],
            ]);
        } else {
            return response()->json([
                'status' => $assignment['status'],
                'message' => $assignment['message'],
            ]);
        }
    }

    public function edit($id) {
        $service = new AssignmentService;
        $assignment = $service->editAssignment($id);
        if ($assignment['status'] == 'success') {
            return response()->json([
                'data' => $assignment['data'],
                'status' => $assignment['status'],
                'message' => $assignment['message'],
            ]);
        } else {
            return response()->json([
                'status' => $assignment['status'],
                'message' => $assignment['message'],
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new AssignmentService;
        $assignment = $service->updateAssignment($request,$id);
        if ($assignment['status'] == 'success') {
            return response()->json([
                'data' => $assignment['data'],
                'status' => $assignment['status'],
                'message' => $assignment['message'],
            ]);
        } else {
            return response()->json([
                'status' => $assignment['status'],
                'message' => $assignment['message'],
            ]);
        }
    }

    public function show($id) {
        $service = new AssignmentService;
        $data = $service->showAssignment($id);
        if ($data['status'] == 'success') {
            return response()->json([
                'assignment' => $data['assignment'],
                'batches' => $data['batches'],
                'status' => $data['status'],
                'message' => $data['message'],
            ]);
        } else {
            return response()->json([
                'status' => $data['status'],
                'message' => $data['message'],
            ]);
        }
    }
}
