<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClassroomService;

class ClassroomController extends Controller
{
    public function index() {
        $service = new ClassroomService;
        $classrooms = $service->getAllClassrooms();

        if ($classrooms) {
            return response()->json([
                'data' => $classrooms,
                'message' => 'Classrooms Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new ClassroomService;
        $classroom = $service->createClassroom($request);

        if ($classroom) {
            return response()->json([
                'data' => $classroom,
                'message' => 'Classroom Created Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new ClassroomService;
        $classroom = $service->editClassroom($id);
        if ($classroom) {
            return response()->json([
                'data' => $classroom,
                'message' => 'Classroom Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new ClassroomService;
        $classroom = $service->updateClassroom($request,$id);
        if ($classroom) {
            return response()->json([
                'data' => $classroom,
                'message' => 'Classroom Updated Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id) {
        $service = new ClassroomService;
        $classroom = $service->deleteClassroom($id);

        if ($classroom) {
            return response()->json([
                'data' => $classroom,
                'message' => 'Classroom Deleted Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id) {
        $service = new ClassroomService;
        $classroom = $service->showClassroom($id);

        if ($classroom) {
            return response()->json([
                'data' => $classroom,
                'message' => 'Classroom Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
