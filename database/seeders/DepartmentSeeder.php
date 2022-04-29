<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\CollegeDepartment;
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ID = 1
        Department::create([
            'name' => 'Computer Engineering Department',
        ]);

        CollegeDepartment::create([
            'college_id' => 1,
            'department_id' => 1,
        ]);
    }
}
