<?php

namespace App\Services;

use App\Models\User;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Imports\UsersRollNumberImport;
class UserService {

    public function getAllUsers() {
        if(Auth::user()->hasPermissionTo('View All Users')) {
            $users = User::all();
            return $users;
        }
    }

    public function createUser($request) {
        if(Auth::user()->hasPermissionTo('Create User')) {
            $user = new User;
            $user->name = $request->name;
            $user->roll_number = $request->roll_number;
            $user->mobile_number = $request->mobile_number;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            $user->assignRole($request->role);
            return $user;
        }
    }

    public function editUser($id) {
        if(Auth::user()->hasPermissionTo('Edit User')) {
            $user = User::find($id);
            return $user;
        }
    }

    public function updateUser($request,$id) {
        if(Auth::user()->hasPermissionTo('Edit User')) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->roll_number = $request->roll_number;
            $user->update();
            return $user;
        }
    }

    public function deleteUser($id) {
        if(Auth::user()->hasPermissionTo('Delete User')) {
            $user = User::find($id);
            $user->delete();
            $user = 'Deleted Successfully';
            return $user;
        }
    }

    public function showUser($id) {
        if(Auth::user()->hasPermissionTo('Show User')) {
            $user = User::find($id);
            return $user;
        }
    }

    public function importUser($request) {
        if(Auth::user()->hasPermissionTo('Import User')) {
            $users = Excel::import(new UsersImport, $request->file);
            $success_message = 'Success';
            return $success_message;
        }
    }

    public function updateRollNumbers($request) {
        if(Auth::user()->hasPermissionTo('Import User')) {
            $users = Excel::import(new UsersRollNumberImport, $request->file);
            $success_message = 'Success';
            return $success_message;
        }
    }

    public function getAllCollegeAdmins() {
        if(Auth::user()->hasPermissionTo('Get All College Admins')) {
            $college_admins = User::role('College Admin')->get();
            return $college_admins;
        }
    }

}
