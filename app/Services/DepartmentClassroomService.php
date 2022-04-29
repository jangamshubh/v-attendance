<?php

namespace App\Services;

use App\Models\DepartmentClassroom;
use Auth;

class DepartmentClassroomService {
    public function getAllDepartmentClassrooms($department_id) {
        if(Auth::user()->hasPermissionTo('View All Department Classrooms')) {
            $classrooms = DepartmentClassroom::where('department_id',$department_id)->get();
            return $classrooms;
        }
    }

    public function createDepartmentClassroom($request) {
        if(Auth::user()->hasPermissionTo('Create Department Classroom')) {
            $classroom = DepartmentClassroom::create($request->all());
            return $classroom;
        }
    }

    public function editDepartmentClassroom($id) {
        if(Auth::user()->hasPermissionTo('Edit Department Classroom')) {
            $classroom = DepartmentClassroom::find($id);
            return $classroom;
        }
    }

    public function updateDepartmentClassroom($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Department Classroom')) {
            $classroom = DepartmentClassroom::find($id);
            $classroom->department_id = $request->department_id;
            $classroom->classroom_id = $request->classroom_id;
            $classroom->admin_id = $request->admin_id;
            $classroom->update();
            return $classroom;
        }
    }

    public function deleteDepartmentClassroom($id) {
        if(Auth::user()->hasPermissionTo('Delete Department Classroom')) {
            $classroom = DepartmentClassroom::find($id);
            $classroom->delete();
        }
    }
}
