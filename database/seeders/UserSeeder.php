<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ID = 1
        $super_admin = User::create([
            'name' => 'Super Admin 1',
            'email' => 'super-admin@chitran.in',
            'mobile_number'=>'9653316033',
            'password' => bcrypt('KsCNABpwW$?s+7pv'),

        ]);
        $super_admin->assignRole('Super Admin');

        // ID = 2
        $vit_college_admin = User::create([
            'name' => 'College Admin',
            'email' => 'vit-admin@chitran.in',
            'mobile_number' => '9876543210',
            'password' => bcrypt('KsCNABpwW$?s+7pv'),
        ]);
        $vit_college_admin->assignRole('College Admin');

        // ID = 3
        $fe_department_admin = User::create([
            'name' => 'FE Department Admin',
            'email' => 'fe-dept-admin@chitran.in',
            'mobile_number' => '0123456789',
            'password' => bcrypt('KsCNABpwW$?s+7pv'),
        ]);
        $fe_department_admin->assignRole('Department Admin');

        // ID = 4
        $chemistry_teacher = User::create([
            'name' => 'CCL Teacher',
            'email' => 'ccl.teacher@vit.edu.in',
            'mobile_number' => '2013456789',
            'password' => bcrypt('password'),
        ]);
        $chemistry_teacher->assignRole('Teacher');
    }
}
