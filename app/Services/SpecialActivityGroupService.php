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

class SpecialActivityGroupService {

    public function getAllGroups($activity_id) {
        if(Auth::user()->hasPermissionTo('Get All Activity Groups')) {
            if(Auth::user()->hasRole('Teacher')) {
                $activity = SpecialActivity::find($activity_id);
                if($activity->added_by == Auth::id()) {
                    $groups = SpecialActivityGroup::where('special_activity_id',$activity_id)->get();
                    return $this->retrieveSuccessMessage($groups);
                } else {
                    return $this->addedByErrorMessage();
                }
            } elseif(Auth::user()->hasRole('Student')) {
                $batches = SpecialActivityBatch::where('activity_id',$activity_id)->pluck('batch_id')->toArray();
                $count = BatchStudent::whereIn('batch_id',$batches)->where('student_id',Auth::id())->count();
                if($count > 0) {
                    $group_id = SpecialActivityGroupMember::where('student_id',Auth::id())->pluck('special_activity_group_id');
                    $members = SpecialActivityGroupMember::where('special_activity_group_id',$group_id)->get();
                    return $this->retrieveSuccessMessage($members);
                } else {
                    return $this->studentAccessErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function createGroup($request,$activity_id) {
        if(Auth::user()->hasPermissionTo('Create Activity Group')) {
            if(Auth::user()->hasRole('Student')) {
                $permission = $this->checkGroupCreationPermission($activity_id);
                if($permission['status'] == 'success') {
                    $group = new SpecialActivityGroup;
                    $group->name = $request->name;
                    $group->special_activity_id = $activity_id;
                    $group->leader_id = Auth::id();
                    $group->save();
                    $members = new SpecialActivityGroupMember;
                    $members->group_id = $group->id;
                    $members->student_id = Auth::id();
                    $members->added_by = Auth::id();
                    $members->status = 0;
                    $members->save();
                    return $this->createGroupSuccessMessage($group);
                } else {
                    return $permission;
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function checkGroupCreationPermission($activity_id) {
        if(Auth::user()->hasPermissionTo('Create Activity Group')) {
            if(Auth::user()->hasRole('Student')) {
                $batches = SpecialActivityBatch::where('activity_id',$activity_id)->pluck('batch_id')->toArray();
                $count = BatchStudent::whereIn('batch_id',$batches)->where('student_id',Auth::id())->count();
                $already_in_group = SpecialActivityGroup::where('member_id',Auth::id())->count();
                if($already_in_group == 0) {
                    if($count > 0) {
                        return $this->groupCreationPermissionSuccessMessage();
                    } else {
                        return $this->groupCreationPermissionErrorMessage();
                    }
                } else {
                    return $this->alreadyInGroupErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        }
    }

    protected function createGroupSuccessMessage($data) {
        $group['status'] = 'success';
        $group['message'] = 'Group Created Successfully!';
        $group['data'] = $data;
        return $group;
    }

    protected function alreadyInGroupErrorMessage() {
        $group['status'] = 'error';
        $group['message'] = 'You are already in a group';
        return $group;
    }

    protected function studentAccessErrorMessage() {
        $group['status'] = 'error';
        $group['message'] = 'You are not allowed to view this data';
        return $group;
    }

    protected function groupCreationPermissionSuccessMessage() {
        $group['status'] = 'success';
        $group['message'] = 'You are allowed to create the group';
        return $group;
    }

    protected function groupCreationPermissionErrorMessage() {
        $group['status'] = 'error';
        $group['message'] = 'You are not allowed to create the group';
        return $group;
    }

    protected function retrieveSuccessMessage($data) {
        $groups['data'] = $data;
        $groups['status'] = 'success';
        $groups['message'] = 'Groups Retrieved Successfully';
        return $groups;
    }

    protected function roleErrorMessage() {
        $groups['status'] = 'error';
        $groups['message'] = "You don't have the correct role to access this data";
        return $groups;
    }

    protected function addedByErrorMessage() {
        $groups['status'] = 'error';
        $groups['message'] = "You haven't added this activity, hence cannot view the data";
        return $groups;
    }
}
