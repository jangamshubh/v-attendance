<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AssignmentSubmissionService;

class AssignmentSubmissionController extends Controller
{

    public function index($assignment_id) {
        $service = new AssignmentSubmissionService;
        $submissions = $service->getAllSubmissions($assignment_id);
        if ($submissions['status'] == 'success') {
            return response()->json([
                'data' => $submissions['data'],
                'message' => $submissions['message'],
                'status' => $submissions['status'],
            ]);
        } else {
            return response()->json([
                'status' => $submissions['status'],
                'message' => $submissions['message'],
            ]);
        }
    }

    public function store(Request $request,$assignment_id) {
        $service = new AssignmentSubmissionService;
        $submission = $service->addSubmission($request,$assignment_id);
        if ($submission['status'] == 'success') {
            return response()->json([
                'data' => $submission['data'],
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        } else {
            return response()->json([
                'status' => $submissions['status'],
                'message' => $submissions['message'],
            ]);
        }
    }


    public function addMarks(Request $request,$assignment_id,$id) {
        $service = new AssignmentSubmissionService;
        $submission = $service->addMarks($request,$assignment_id,$id);
        if ($submission['status'] == 'success') {
            return response()->json([
                'data' => $submission['data'],
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        } else {
            return response()->json([
                'status' => $submissions['status'],
                'message' => $submissions['message'],
            ]);
        }
    }

    public function checkTime($assignment_id) {
        $service = new AssignmentSubmissionService;
        $submission = $service->checkTime($assignment_id);
        if ($submission['status'] == 'success') {
            return response()->json([
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        } else {
            return response()->json([
                'status' => $submissions['status'],
                'message' => $submissions['message'],
            ]);
        }
    }

    public function checkSubmissionPermission($assignment_id) {
        $service = new AssignmentSubmissionService;
        $submission = $service->checkSubmissionPermission($assignment_id);
        if ($submission['status'] == 'success') {
            return response()->json([
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        } else {
            return response()->json([
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        }
    }

    public function checkAddMarksPermission($assignment_id) {
        $service = new AssignmentSubmissionService;
        $submission = $service->checkAddMarksPermission($assignment_id);
        if ($submission['status'] == 'success') {
            return response()->json([
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        } else {
            return response()->json([
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        }
    }

    public function show($assignment_id,$id) {
        $service = new AssignmentSubmissionService;
        $submission = $service->showSubmission($assignment_id,$id);
        if ($submission['status'] == 'success') {
            return response()->json([
                'data' => $submission['data'],
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        } else {
            return response()->json([
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        }
    }

    public function autoEvaluate(Request $request,$assignment_id) {
        $service = new AssignmentSubmissionService;
        $submission = $service->autoEvaluate($request,$assignment_id);
        if ($submission['status'] == 'success') {
            return response()->json([
                'data' => $submission['data'],
                'status' => $submission['status'],
                'message' => $submission['message'],
            ]);
        } else {
            return response()->json([
                'message' => $submission['message'],
                'status' => $submission['status'],
            ]);
        }
    }
}
