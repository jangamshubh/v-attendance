<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DepartmentClassroomService;

class DepartmentClassroomController extends Controller
{
    public function index($department_id) {
        $service = new DepartmentClassroomService;
        $classrooms = $service->getAllDepartmentClassrooms($department_id);
        if ($classrooms) {
            return response()->json([
                'data' => $classrooms,
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
        $service = new DepartmentClassroomService;
        $classroom = $service->createDepartmentClassroom($request);
        if ($classroom) {
            return response()->json([
                'data' => $classroom,
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
        $service = new DepartmentClassroomService;
        $classroom = $service->editDepartmentClassroom($id);
        if ($classroom) {
            return response()->json([
                'data' => $classroom,
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
        $service = new DepartmentClassroomService;
        $classroom = $service->updateDepartmentClassroom($request,$id);
        if ($classroom) {
            return response()->json([
                'data' => $classroom,
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
        $service = new DepartmentClassroomService;
        $classroom = $service->deleteDepartmentClassroom($id);
        if ($classroom) {
            return response()->json([
                'data' => $classroom,
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
