<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;

class RoleController extends Controller
{

    public function index() {
        $service = new RoleService;
        $roles = $service->getAllRoles();
        if ($roles) {
            return response()->json([
                'data' => $roles,
                'message' => 'Roles Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request) {
        $service = new RoleService;
        $role = $service->createRole();
        if ($role) {
            return response()->json([
                'data' => $role,
                'message' => 'Role Created Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function edit($id) {
        $service = new RoleService;
        $role = $service->editRole($id);
        if ($role) {
            return response()->json([
                'data' => $role,
                'message' => 'Role Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request,$id) {
        $service = new RoleService;
        $role = $service->updateRole($request,$id);
        if ($role) {
            return response()->json([
                'data' => $role,
                'message' => 'Role Updated Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function show($id) {
        $service = new RoleService;
        $role = $service->showRole($id);
        if ($role) {
            return response()->json([
                'data' => $role,
                'message' => 'Role Retrieved Successfully',
                'status' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }
}
