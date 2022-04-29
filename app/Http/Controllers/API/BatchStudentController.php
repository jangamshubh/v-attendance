<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BatchStudentService;

class BatchStudentController extends Controller
{
    public function getAllStudentBatchSubjects() {
        $service = new BatchStudentService;
        $subjects = $service->getAllStudentBatchSubjects();
        if ($subjects) {
            return response()->json([
                'data' => $subjects,
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
