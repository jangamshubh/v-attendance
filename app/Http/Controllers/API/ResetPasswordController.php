<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ResetPasswordService;

class ResetPasswordController extends Controller
{
    public function generateOTP(Request $request) {
        $service = new ResetPasswordService;
        $data = $service->generateOTP($request);
        return response()->json([
            'unique_identifier' => $data['unique_identifier'],
            'status' => $data['status'],
        ]);
    }

    public function checkOTP(Request $request,$unique_identifier) {
        $service = new ResetPasswordService;
        $data = $service->checkOTP($request,$unique_identifier);
        if($data['status'] == 'success') {
            return response()->json([
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

    public function resetPassword(Request $request,$unique_identifier) {
        $service = new ResetPasswordService;
        $data = $service->resetPassword($request,$unique_identifier);
        if($data['status'] == 'success') {
            return response()->json([
                'status' => $data['status'],
                'message' => $data['message'],
                'user' => $data['user']
            ]);
        } else {
            return response()->json([
                'status' => $data['status'],
                'message' => $data['message'],
            ]);
        }
    }

    public function checkStatus($unique_identifier) {
        $service = new ResetPasswordService;
        $data = $service->checkStatus($unique_identifier);
        if($data['status'] == 'success') {
            return response()->json([
                'status' => $data['status'],
                'message' => $data['message'],
                'data' => $data['data']
            ]);
        } else {
            return response()->json([
                'status' => $data['status'],
                'message' => $data['message'],
            ]);
        }
    }


}
