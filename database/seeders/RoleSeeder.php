<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ID = 1
        Role::create([
            'name' => 'Super Admin',
        ]);

        // ID = 2
        Role::create([
            'name' => 'College Admin',
        ]);

        // ID = 3
        Role::create([
            'name' => 'Department Admin',
        ]);

        // ID = 4
        Role::create([
            'name' => 'Class Coordinator',
        ]);

        // ID = 5
        Role::create([
            'name' => 'Batch Coordinator'
        ]);

        // ID = 6
        Role::create([
            'name' => 'Teacher',
        ]);

        // ID = 7
        Role::create([
            'name' => 'Student',
        ]);
    }
}
