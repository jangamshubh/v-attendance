<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CollegeDepartmentService;

class CollegeDepartmentController extends Controller
{
    public function index($college_id) {
        $service = new CollegeDepartmentService;
        $departments = $service->getAllCollegeDepartments($college_id);
        if ($departments) {
            return response()->json([
                'data' => $departments,
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
        $service = new CollegeDepartmentService;
        $department = $service->createCollegeDepartment($request);
        if ($department) {
            return response()->json([
                'data' => $department,
                'status' => 'Success',
                'message' => 'College & Department Attached Successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new CollegeDepartmentService;
        $department = $service->editCollegeDepartment($id);
        if ($department) {
            return response()->json([
                'data' => $department,
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
        $service = new CollegeDepartmentService;
        $department = $service->updateCollegeDepartment($request,$id);
        if ($department) {
            return response()->json([
                'data' => $department,
                'status' => 'Success',
                'message' => 'Data Retrieved Successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id) {
        $service = new CollegeDepartmentService;
        $department = $service->deleteCollegeDepartment($id);
        if ($department) {
            return response()->json([
                'data' => $department,
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
