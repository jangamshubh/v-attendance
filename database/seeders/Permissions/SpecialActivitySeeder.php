<?php

namespace Database\Seeders\Permissions;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class SpecialActivitySeeder extends Seeder
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


        $view_all = Permission::create(['name' => 'Get All Activities']);
        $create = Permission::create(['name' => 'Create Activity']);
        $edit = Permission::create(['name' => 'Edit Activity']);
        $view = Permission::create(['name' => 'View Activity']);
        $delete = Permission::create(['name' => 'Delete Activity']);
        $sync_permissions_teacher = $teacher_role->givePermissionTo([$view_all, $create, $edit, $delete, $view]);
    }
}
