<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CollegeService;

class CollegeController extends Controller
{
    public function index() {
        $service = new CollegeService;
        $colleges = $service->getAllColleges();

        if ($colleges) {
            return response()->json([
                'data' => $colleges,
                'message' => 'Colleges Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new CollegeService;
        $college = $service->createCollege($request);

        if ($college) {
            return response()->json([
                'data' => $college,
                'message' => 'College Created Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new CollegeService;
        $college = $service->editCollege($id);
        if ($college) {
            return response()->json([
                'data' => $college,
                'message' => 'College Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new CollegeService;
        $college = $service->updateCollege($request,$id);
        if ($college) {
            return response()->json([
                'data' => $college,
                'message' => 'College Updated Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id) {
        $service = new CollegeService;
        $college = $service->deleteCollege($id);

        if ($college) {
            return response()->json([
                'data' => $college,
                'message' => 'College Deleted Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id) {
        $service = new CollegeService;
        $college = $service->showCollege($id);

        if ($college) {
            return response()->json([
                'data' => $college,
                'message' => 'College Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
