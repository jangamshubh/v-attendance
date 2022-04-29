<?php

namespace App\Services;

use App\Models\Subject;
use Auth;

class SubjectService {

    public function getAllSubjects() {
        if(Auth::user()->hasPermissionTo('View All Subjects')) {
            $subjects = Subject::all();
            return $subjects;
        }
    }

    public function createSubject($request) {
        if(Auth::user()->hasPermissionTo('Create Subject')) {
            $subject = new Subject;
            $subject->create($request->all());
            return $subject;
        }
    }

    public function editSubject($id) {
        if(Auth::user()->hasPermissionTo('Edit Subject')) {
            $subject = Subject::find($id);
            return $subject;
        }
    }

    public function updateSubject($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit Subject')) {
            $subject = Subject::find($id);
            $subject->name = $request->name;
            $subject->code = $request->code;
            $subject->update();
            return $subject;
        }
    }

    public function showSubject($id) {
        if(Auth::user()->hasPermissionTo('Show Subject')) {
            $subject = Subject::find($id);
            return $subject;
        }
    }

    public function deleteSubject($id) {
        if(Auth::user()->hasPermissionTo('Delete Subject')) {
            $subject = Subject::find($id);
            $subject->delete();
            $subject = 'Deleted Successfully';
            return $subject;
        }
    }
}
