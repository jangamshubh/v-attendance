<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfileService;
class ProfileController extends Controller
{
    public function getProfile() {
        $service = new ProfileService;
        $profile = $service->getProfile();
        if($profile['status'] == 'success') {
            return response()->json([
                'status' => $profile['status'],
                'message' => $profile['message'],
                'data' => $profile['data'],
            ]);
        } else {
            return response()->json([
                'status' => $profile['status'],
                'message' => $profile['message'],
            ]);
        }
    }

    public function update(Request $request) {
        $service = new ProfileService;
        $profile = $service->updateProfile($request);
        if($profile['status'] == 'success') {
            return response()->json([
                'status' => $profile['status'],
                'message' => $profile['message'],
                'data' => $profile['data'],
            ]);
        } else {
            return response()->json([
                'status' => $profile['status'],
                'message' => $profile['message'],
            ]);
        }
    }
}
