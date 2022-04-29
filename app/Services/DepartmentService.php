<?php

namespace App\Services;

use App\Models\Department;
use Auth;

class DepartmentService {

    public function getAllDepartments() {
        if(Auth::user()->hasPermissionTo('View All Departments')) {
            $departments = Department::all();
            return $departments;
        }
    }

    public function createDepartment($request) {
        if(Auth::user()->hasPermissionTo('Create Department')) {
            $department = new Department;
            $department->create($request->all());
            return $department;
        }
    }

    public function editDepartment($id) {
        if(Auth::user()->hasPermissionTo('Edit Department')) {
            $department = Department::find($id);
            return $department;
        }
    }

    public function updateDepartment($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Department')) {
            $department = Department::find($id);
            $department->name = $request->name;
            $department->update();
            return $department;
        }
    }

    public function showDepartment($id) {
        if(Auth::user()->hasPermissionTo('Show Department')) {
            $department = Department::find($id);
            return $department;
        }
    }

    public function deleteDepartment($id) {
        if(Auth::user()->hasPermissionTo('Delete Department')) {
            $department = Department::find($id);
            $department->delete();
            $department = 'Deleted Successfully';
            return $department;
        }
    }
}
