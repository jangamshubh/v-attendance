<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SubjectService;

class SubjectController extends Controller
{
    public function index() {
        $service = new SubjectService;
        $subjects = $service->getAllSubjects();

        if ($subjects) {
            return response()->json([
                'data' => $subjects,
                'message' => 'Subjects Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new SubjectService;
        $subject = $service->createSubject($request);

        if ($subject) {
            return response()->json([
                'data' => $subject,
                'message' => 'Subject Created Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new SubjectService;
        $subject = $service->editSubject($id);
        if ($subject) {
            return response()->json([
                'data' => $subject,
                'message' => 'Subject Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new SubjectService;
        $subject = $service->updateSubject($request,$id);
        if ($subject) {
            return response()->json([
                'data' => $subject,
                'message' => 'Subject Updated Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id) {
        $service = new SubjectService;
        $subject = $service->deleteSubject($id);

        if ($subject) {
            return response()->json([
                'data' => $subject,
                'message' => 'Subject Deleted Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id) {
        $service = new SubjectService;
        $subject = $service->showSubject($id);

        if ($subject) {
            return response()->json([
                'data' => $subject,
                'message' => 'Subject Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
