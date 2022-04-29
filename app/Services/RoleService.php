<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Auth;

class RoleService {

    public function getAllRoles() {
        if(Auth::user()->hasPermissionTo('View All Roles')) {
            $roles = Role::all();
            return $roles;
        }
    }

    public function createRole($request) {
        if(Auth::user()->hasPermissionTo('Create Role')) {
            $role = new Role;
            $role->name = $request->name;
            $role->save();
            return $role;
        }
    }

    public function editRole($id) {
        if(Auth::user()->hasPermissionTo('Edit Role')) {
            $role = Role::find($id);
            return $role;
        }
    }

    public function updateRole($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Role')) {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->update();
            return $role;
        }
    }

    public function showRole($id) {
        if(Auth::user()->hasPermissionTo('Show Role')) {
            $role = Role::find($id);
            return $role;
        }
    }

}
