<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(){
        $service = new UserService;
        $users = $service->getAllUsers();
        if ($users) {
            return response()->json([
                'data' => $users,
                'message' => 'Users Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(StoreUserRequest $request){
        $service = new UserService;
        $user = $service->createUser($request);
        if ($user) {
            return response()->json([
                'data' => $user,
                'message' => 'User Created Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id){
        $service = new UserService;
        $user = $service->editUser($id);
        if ($user) {
            return response()->json([
                'data' => $user,
                'message' => 'User Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(UpdateUserRequest $request,$id){
        $service = new UserService;
        $user = $service->updateUser($request,$id);
        if ($user) {
            return response()->json([
                'data' => $user,
                'message' => 'User Updated Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id){
        $service = new UserService;
        $user = $service->showUser($id);
        if ($user) {
            return response()->json([
                'data' => $user,
                'message' => 'User Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function delete($id){
        $service = new UserService;
        $user = $service->deleteUser($id);
        if ($user) {
            return response()->json([
                'data' => $user,
                'message' => 'User Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function import(Request $request) {
        $service = new UserService;
        $import = $service->importUser($request);
        if ($import) {
            return response()->json([
                'data' => $import,
                'message' => 'Users Imported Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function updateRollNumbers(Request $request) {
        $service = new UserService;
        $import = $service->updateRollNumbers($request);
        if ($import) {
            return response()->json([
                'data' => $import,
                'message' => 'Users Imported Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function getAllCollegeAdmins() {
        $service = new UserService;
        $users = $service->getAllCollegeAdmins();
        if ($users) {
            return response()->json([
                'data' => $users,
                'message' => 'Users Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
