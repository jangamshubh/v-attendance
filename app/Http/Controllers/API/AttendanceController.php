<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AttendanceService;

class AttendanceController extends Controller
{
    public function index($batch_id) {
        $service = new AttendanceService;
        $attendances = $service->getAllAttendances($batch_id);
        if ($attendances['status'] == 'success') {
            return response()->json([
                'data' => $attendances['data'],
                'message' => $attendances['message'],
                'status' => $attendances['status'],
            ]);
        } else {
            return response()->json([
                'message' => $attendances['message'],
                'status' => $attendances['status'],
            ]);
        }
    }

    public function store(Request $request) {
        $service = new AttendanceService;
        $attendance = $service->addAttendance($request);
        if ($attendance['status'] == 'success') {
            return response()->json([
                'data' => $attendance['data'],
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        } else {
            return response()->json([
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        }
    }

    public function getAttendanceStudents($attendance_id) {
        $service = new AttendanceService;
        $attendance = $service->getAttendanceStudents($attendance_id);
        if ($attendance['status'] == 'success') {
            return response()->json([
                'data' => $attendance['data'],
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        } else {
            return response()->json([
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        }
    }

    public function takeAttendance(Request $request,$attendance_id) {
        $service = new AttendanceService;
        $attendance = $service->takeAttendance($request,$attendance_id);
        if ($attendance['status'] == 'success') {
            return response()->json([
                'data' => $attendance['data'],
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        } else {
            return response()->json([
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        }
    }

    public function edit($attendance_id) {
        $service = new AttendanceService;
        $data = $service->editAttendance($attendance_id);
        if ($data['status'] == 'success') {
            return response()->json([
                'data' => $data['data'],
                'message' => $data['message'],
                'status' => $data['status'],
            ]);
        } else {
            return response()->json([
                'message' => $data['message'],
                'status' => $data['status'],
            ]);
        }
    }

    public function update(Request $request,$attendance_id) {
        $service = new AttendanceService;
        $data = $service->updateAttendance($request,$attendance_id);
        if ($data['status'] == 'success') {
            return response()->json([
                'attendance' => $data['data'],
                'message' => $data['message'],
                'status' => $data['status'],
            ]);
        } else {
            return response()->json([
                'message' => $data['message'],
                'status' => $data['status'],
            ]);
        }
    }

    public function show($attendance_id) {
        $service = new AttendanceService;
        $data = $service->showAttendance($attendance_id);
        if ($data['status'] == 'success') {
            return response()->json([
                'attendance' => $data['attendance'],
                'attendance_batches' => $data['batches'],
                'attendance_students' => $data['students'],
                'message' => $data['message'],
                'status' => $data['status'],
            ]);
        } else {
            return response()->json([
                'message' => $data['message'],
                'status' => $data['status'],
            ]);
        }
    }

    public function getAllStudentAttendance($subject_id) {
        $service = new AttendanceService;
        $attendances = $service->getAllStudentAttendance($subject_id);
        if ($attendances['status'] == 'success') {
            return response()->json([
                'data' => $attendances['data'],
                'message' => $attendances['message'],
                'status' => $attendances['status'],
            ]);
        } else {
            return response()->json([
                'message' => $attendances['message'],
                'status' => $attendances['status'],
            ]);
        }
    }


    public function duplicateAttendance(Request $request,$attendance_id) {
        $service = new AttendanceService;
        $attendance = $service->duplicateAttendance($request,$attendance_id);
        if ($attendance['status'] == 'success') {
            return response()->json([
                'data' => $attendance['data'],
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        } else {
            return response()->json([
                'message' => $attendance['message'],
                'status' => $attendance['status'],
            ]);
        }
    }
}
