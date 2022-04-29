<?php

namespace App\Services;

use App\Models\CollegeDepartment;
use Auth;

class CollegeDepartmentService {

    public function getAllCollegeDepartments($college_id) {
        if(Auth::user()->hasPermissionTo('View All College Departments')) {
            $departments = CollegeDepartment::where('college_id',$college_id)->get();
            return $departments;
        }
    }

    public function createCollegeDepartment($request) {
        if(Auth::user()->hasPermissionTo('Create College Department')) {
            $department = CollegeDepartment::create($request->all());
            return $department;
        }
    }

    public function editCollegeDepartment($id) {
        if(Auth::user()->hasPermissionTo('Edit College Department')) {
            $department = CollegeDepartment::find($id);
            return $department;
        }
    }

    public function updateCollegeDepartment($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit College Department')) {
            $department = CollegeDepartment::find($id);
            $department->college_id = $request->college_id;
            $department->department_id = $request->department_id;
            $department->admin_id = $request->admin_id;
            $department->update();
            return $department;
        }
    }

    public function deleteCollegeDepartment($id) {
        if(Auth::user()->hasPermissionTo('Delete College Department')) {
            $department = CollegeDepartment::find($id);
            $department->delete();
        }
    }

}
