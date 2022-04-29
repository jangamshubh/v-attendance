<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PracticalService;

class PracticalController extends Controller
{
    public function index() {
        $service = new PracticalService;
        $practicals = $service->getAllPracticals();
        if ($practicals) {
            return response()->json([
                'data' => $practicals,
                'message' => 'success',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new PracticalService;
        $practical = $service->storePractical($request);
        if ($practical) {
            return response()->json([
                'data' => $practical,
                'message' => 'success',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new PracticalService;
        $practical = $service->editPractical($id);
        if ($practical) {
            return response()->json([
                'data' => $practical,
                'message' => 'success',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new PracticalService;
        $practical = $service->updatePractical($request,$id);
        if ($practical) {
            return response()->json([
                'data' => $practical,
                'message' => 'success',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id) {
        $service = new PracticalService;
        $data = $service->showPractical($id);
        if ($data) {
            return response()->json([
                'practical' => $data[0],
                'batches' => $data[1],
                'message' => 'success',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
