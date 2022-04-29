<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin_role = Role::find(1);
        $teacher_role = Role::find(6);
        $student_role = Role::find(7);

        // Roles Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Roles']);
        $create = Permission::create(['name' => 'Create Role']);
        $edit = Permission::create(['name' => 'Edit Role']);
        $show = Permission::create(['name' => 'Show Role']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $show ]);
        // Roles Module Permissions End


        // Users Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Users']);
        $create = Permission::create(['name' => 'Create User']);
        $edit = Permission::create(['name' => 'Edit User']);
        $show = Permission::create(['name' => 'Show User']);
        $delete = Permission::create(['name' => 'Delete User']);
        $import = Permission::create(['name' => 'Import User']);
        $get_all_college_admin = Permission::create(['name' => 'Get All College Admins']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $show, $delete,$import,$get_all_college_admin]);
        // Users Module Permissions End


        // College Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Colleges']);
        $create = Permission::create(['name' => 'Create College']);
        $edit = Permission::create(['name' => 'Edit College']);
        $show = Permission::create(['name' => 'Show College']);
        $delete = Permission::create(['name' => 'Delete College']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $show, $delete ]);
        // College Module Permissions End


        // Department Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Departments']);
        $create = Permission::create(['name' => 'Create Department']);
        $edit = Permission::create(['name' => 'Edit Department']);
        $show = Permission::create(['name' => 'Show Department']);
        $delete = Permission::create(['name' => 'Delete Department']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $show, $delete ]);
        // Department Module Permissions End

        // Classroom Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Classrooms']);
        $create = Permission::create(['name' => 'Create Classroom']);
        $edit = Permission::create(['name' => 'Edit Classroom']);
        $show = Permission::create(['name' => 'Show Classroom']);
        $delete = Permission::create(['name' => 'Delete Classroom']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $show, $delete ]);
        // Classroom Module Permissions End

        // Batches Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Batches']);
        $create = Permission::create(['name' => 'Create Batch']);
        $edit = Permission::create(['name' => 'Edit Batch']);
        $show = Permission::create(['name' => 'Show Batch']);
        $delete = Permission::create(['name' => 'Delete Batch']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $show, $delete ]);
        // Batches Module Permissions End


        // Subjects Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Subjects']);
        $create = Permission::create(['name' => 'Create Subject']);
        $edit = Permission::create(['name' => 'Edit Subject']);
        $show = Permission::create(['name' => 'Show Subject']);
        $delete = Permission::create(['name' => 'Delete Subject']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $show, $delete ]);
        // Subjects Module Permissions End


        // College Departments Module Permissions Start
        $view_all = Permission::create(['name' => 'View All College Departments']);
        $create = Permission::create(['name' => 'Create College Department']);
        $edit = Permission::create(['name' => 'Edit College Department']);
        $delete = Permission::create(['name' => 'Delete College Department']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $delete ]);
        // College Departments Module Permissions End

        // Department Classrooms Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Department Classrooms']);
        $create = Permission::create(['name' => 'Create Department Classroom']);
        $edit = Permission::create(['name' => 'Edit Department Classroom']);
        $delete = Permission::create(['name' => 'Delete Department Classroom']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $delete ]);
        // Department Classrooms Module Permissions End

        // Classroom Batches Module Permissions Start
        $view_all = Permission::create(['name' => 'View All Classroom Batches']);
        $create = Permission::create(['name' => 'Create Classroom Batch']);
        $edit = Permission::create(['name' => 'Edit Classroom Batch']);
        $delete = Permission::create(['name' => 'Delete Classroom Batch']);
        $sync_permissions = $super_admin_role->givePermissionTo([ $view_all, $create, $edit, $delete ]);
        // Classroom Batches Module Permissions End

        // Assignments Module Permissions Start
        $view_all = Permission::create(['name' => 'Get All Assignments']);
        $create = Permission::create(['name' => 'Create Assignment']);
        $edit = Permission::create(['name' => 'Edit Assignment']);
        $view = Permission::create(['name' => 'View Assignment']);
        $delete = Permission::create(['name' => 'Delete Assignment']);
        $sync_permissions_teacher = $teacher_role->givePermissionTo([$view_all, $create, $edit, $delete, $view]);
        $sync_permissions_student = $student_role->givePermissionTo([$view_all,$view]);
        // Assignments Module Permissions End

        // Assignment Submissions Module Permissions Start
        $view_all = Permission::create(['name' => 'Get All Submissions']);
        $add_submission = Permission::create(['name' => 'Add Submission']);
        $add_marks_teacher = Permission::create(['name' => 'Add Marks']);
        $view = Permission::create(['name' => 'View Submission']);
        $sync_permissions_teacher = $teacher_role->givePermissionTo([ $view_all, $add_marks_teacher, $view ]);
        $sync_permissions_student = $student_role->givePermissionTo([ $view_all, $add_submission, $view ]);
        // Assignment Submissions Module Permissions End

        // Attendance Module Permissions Start
        $view_all = Permission::create(['name' => 'Get Individual Teacher Attendances']);
        $create = Permission::create(['name' => 'Add Attendance']);
        $view_all_student = Permission::create(['name' => 'Get All Student Attendances']);
        $view = Permission::create(['name' => 'Show Attendance']);
        $sync_permissions = $teacher_role->givePermissionTo([$view_all, $create, $view]);
        $sync_permissions = $student_role->givePermissionTo([$view_all_student, $view]);
        // Attendance Module Permissions End


        // Practicals Module Permissions Start
        $view_all = Permission::create(['name' => 'Get Individual Teacher Practicals']);
        $create = Permission::create(['name' => 'Create Individual Teacher Practical']);
        $edit = Permission::create(['name' => 'Edit Individual Teacher Practical']);
        $view_all_student = Permission::create(['name' => 'Get Individual Student Practicals']);
        $view_teacher = Permission::create(['name' => 'View Individual Teacher Practical']);
        $view_student = Permission::create(['name' => 'View Individual Student Practical']);
        $sync_permissions_teacher = $teacher_role->givePermissionTo([$view_all, $create, $edit, $view_teacher]);
        $sync_permissions_student = $student_role->givePermissionTo([$view_all_student,$view_student]);
        // Practicals Module Permissions End

    }
}
