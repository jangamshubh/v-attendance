<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PracticalSubmissionService;

class PracticalSubmissionController extends Controller
{
    public function index($practical_id) {
        $service = new PracticalSubmissionService;
        $submissions = $service->getAllSubmissions($practical_id);
        if ($submissions) {
            return response()->json([
                'data' => $submissions,
                'message' => ' ',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request,$practical_id) {
        $service = new PracticalSubmissionService;
        $submission = $service->addSubmission($request,$practical_id);
        if ($submission) {
            return response()->json([
                'data' => $submission,
                'message' => ' ',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }


    public function addMarks(Request $request,$practical_id,$id) {
        $service = new PracticalSubmissionService;
        $submission = $service->addMarks($request,$practical_id,$id);
        if ($submission) {
            return response()->json([
                'data' => $submission,
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function checkTime($practical_id) {
        $service = new PracticalSubmissionService;
        $submission = $service->checkTime($practical_id);
        if ($submission) {
            return response()->json([
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function checkSubmissionPermission($practical_id) {
        $service = new PracticalSubmissionService;
        $submission = $service->checkSubmissionPermission($practical_id);
        if ($submission) {
            return response()->json([
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function checkAddMarksPermission($practical_id) {
        $service = new PracticalSubmissionService;
        $submission = $service->checkAddMarksPermission($practical_id);
        if ($submission) {
            return response()->json([
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($practical_id,$id) {
        $service = new PracticalSubmissionService;
        $submission = $service->showSubmission($practical_id,$id);
        if ($submission) {
            return response()->json([
                'data' => $submission,
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function autoEvaluate(Request $request,$practical_id) {
        $service = new PracticalSubmissionService;
        $submission = $service->autoEvaluate($request,$practical_id);
        if ($submission) {
            return response()->json([
                'data' => $submission,
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
