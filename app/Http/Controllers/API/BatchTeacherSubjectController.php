<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BatchTeacherSubjectService;

class BatchTeacherSubjectController extends Controller
{
    public function getTeacherSubjects() {
        $service = new BatchTeacherSubjectService;
        $subjects = $service->getTeacherSubjects();
        if ($subjects['status'] == 'success') {
            return response()->json([
                'data' => $subjects['data'],
                'status' => $subjects['status'],
                'message' => $subjects['message'],
            ]);
        } else {
            return response()->json([
                'status' => $subjects['status'],
                'message' => $subjects['message'],
            ]);
        }
    }


    public function getTeacherClassrooms($subject_id) {
        $service = new BatchTeacherSubjectService;
        $classrooms = $service->getTeacherClassrooms($subject_id);
        if ($classrooms['status'] == 'success') {
            return response()->json([
                'data' => $classrooms['data'],
                'status' => $classrooms['status'],
                'message' => $classrooms['message'],
            ]);
        } else {
            return response()->json([
                'status' => $classrooms['status'],
                'message' => $classrooms['message'],
            ]);
        }
    }

    public function getTeacherBatches($classroom_id) {
        $service = new BatchTeacherSubjectService;
        $batches = $service->getTeacherBatches($classroom_id);
        if ($batches['status'] == 'success') {
            return response()->json([
                'data' => $batches['data'],
                'status' => $batches['status'],
                'message' => $batches['message'],
            ]);
        } else {
            return response()->json([
                'status' => $batches['status'],
                'message' => $batches['message'],
            ]);
        }
    }
}
