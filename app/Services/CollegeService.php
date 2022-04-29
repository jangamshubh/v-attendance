<?php

namespace App\Services;

use App\Models\College;
use Auth;

class CollegeService {

    public function getAllColleges() {
        if(Auth::user()->hasPermissionTo('View All Colleges')) {
            $colleges = College::all();
            return $colleges;
        }
    }

    public function createCollege($request) {
        if(Auth::user()->hasPermissionTo('Create College')) {
            $college = new College;
            $college->create($request->all());
            return $college;
        }
    }

    public function editCollege($id) {
        if(Auth::user()->hasPermissionTo('Edit College')) {
            $college = College::find($id);
            return $college;
        }
    }

    public function updateCollege($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit College')) {
            $college = College::find($id);
            $college->update($request->all());
            return $college;
        }
    }

    public function showCollege($id) {
        if(Auth::user()->hasPermissionTo('Show College')) {
            $college = College::where('id',$id)->with('college_get_admins')->first();
            return $college;
        }
    }

    public function deleteCollege($id) {
        if(Auth::user()->hasPermissionTo('Delete College')) {
            $college = College::find($id);
            $college->delete();
            $college = 'Deleted Successfully';
            return $college;
        }
    }
}
