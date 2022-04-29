<?php

namespace App\Services;

use App\Models\Classroom;
use Auth;

class ClassroomService {

    public function getAllClassrooms() {
        if(Auth::user()->hasPermissionTo('View All Classrooms')) {
            $classrooms = Classroom::all();
            return $classrooms;
        }
    }

    public function createClassroom($request) {
        if(Auth::user()->hasPermissionTo('Create Classroom')) {
            $classroom = new Classroom;
            $classroom->create($request->all());
            return $classroom;
        }
    }

    public function editClassroom($id) {
        if(Auth::user()->hasPermissionTo('Edit Classroom')) {
            $classroom = Classroom::find($id);
            return $classroom;
        }
    }

    public function updateClassroom($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Classroom')) {
            $classroom = Classroom::find($id);
            $classroom->name = $request->name;
            $classroom->admin_id = $request->admin_id;
            $classroom->update();
            return $classroom;
        }
    }

    public function showClassroom($id) {
        if(Auth::user()->hasPermissionTo('Show Classroom')) {
            $classroom = Classroom::find($id);
            return $classroom;
        }
    }

    public function deleteClassroom($id) {
        if(Auth::user()->hasPermissionTo('Delete Classroom')) {
            $classroom = Classroom::find($id);
            $classroom->delete();
            $classroom = 'Deleted Successfully';
            return $classroom;
        }
    }
}
