<?php

namespace App\Services;

use Auth;
use App\Models\SpecialActivity;
use App\Models\SpecialActivityGroup;
use App\Models\SpecialActivityGroupMember;
use App\Models\SpecialActivityBatch;
use App\Models\Classroom;
use Carbon\Carbon;
use App\Models\BatchTeacherSubject;
use App\Models\BatchStudent;
use App\Models\Subject;
use App\Models\ClassroomBatch;
use App\Models\Batch;

class SpecialActivityGroupMemberService {


    public function addMembers($request) {
        if(Auth::user()->hasPermissionTo('Add Special Activity Group Members')) {
            if(Auth::user()->hasRole('Student')) {
                
            }
        }
    }
}
