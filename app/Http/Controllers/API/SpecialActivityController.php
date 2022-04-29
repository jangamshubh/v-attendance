<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SpecialActivityService;

class SpecialActivityController extends Controller
{
    public function index() {
        $service = new SpecialActivityService;
        $activities = $service->getAllActivities();
        if ($activities['status'] == 'success') {
            return response()->json([
                'data' => $activities['data'],
                'status' => $activities['status'],
                'message' => $activities['message'],
            ]);
        } else {
            return response()->json([
                'status' => $activities['status'],
                'message' => $activities['message'],
            ]);
        }
    }

    public function store(Request $request) {
        $service = new SpecialActivityService;
        $activity = $service->storeSpecialActivity($request);
        if ($activity['status'] == 'success') {
            return response()->json([
                'data' => $activity['data'],
                'status' => $activity['status'],
                'message' => $activity['message'],
            ]);
        } else {
            return response()->json([
                'status' => $activity['status'],
                'message' => $activity['message'],
            ]);
        }
    }

    public function edit($id) {
        $service = new SpecialActivityService;
        $activity = $service->editSpecialActivity($id);
        if ($activity['status'] == 'success') {
            return response()->json([
                'data' => $activity['data'],
                'status' => $activity['status'],
                'message' => $activity['message'],
            ]);
        } else {
            return response()->json([
                'status' => $activity['status'],
                'message' => $activity['message'],
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new SpecialActivityService;
        $activity = $service->updateSpecialActivity($request,$id);
        if ($activity['status'] == 'success') {
            return response()->json([
                'data' => $activity['data'],
                'status' => $activity['status'],
                'message' => $activity['message'],
            ]);
        } else {
            return response()->json([
                'status' => $activity['status'],
                'message' => $activity['message'],
            ]);
        }
    }

    public function show($id) {
        $service = new SpecialActivityService;
        $data = $service->showSpecialActivity($id);
        if ($data['status'] == 'success') {
            return response()->json([
                'activity' => $data['activity'],
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
