<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    public function index() {
        $service = new DepartmentService;
        $departments = $service->getAllDepartments();

        if ($departments) {
            return response()->json([
                'data' => $departments,
                'message' => 'Departments Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new DepartmentService;
        $department = $service->createDepartment($request);

        if ($department) {
            return response()->json([
                'data' => $department,
                'message' => 'Department Created Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new DepartmentService;
        $department = $service->editDepartment($id);
        if ($department) {
            return response()->json([
                'data' => $department,
                'message' => 'Department Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new DepartmentService;
        $department = $service->updateDepartment($request,$id);
        if ($department) {
            return response()->json([
                'data' => $department,
                'message' => 'Department Updated Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id) {
        $service = new DepartmentService;
        $department = $service->deleteDepartment($id);

        if ($department) {
            return response()->json([
                'data' => $department,
                'message' => 'Department Deleted Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id) {
        $service = new DepartmentService;
        $department = $service->showDepartment($id);

        if ($department) {
            return response()->json([
                'data' => $department,
                'message' => 'Department Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
