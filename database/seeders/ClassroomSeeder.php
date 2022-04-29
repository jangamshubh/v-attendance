<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\DepartmentClassroom;
class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ID = 1
        Classroom::create(['name' => 'FE CMPN - A']);

        // ID = 2
        Classroom::create(['name' => 'FE CMPN - B']);

        // ID = 3
        Classroom::create(['name' => 'FE INFT - A']);

        // ID = 4
        Classroom::create(['name' => 'FE INFT - B']);

        // ID = 5
        Classroom::create(['name' => 'TE CMPN - A']);

        // ID = 6
        Classroom::create(['name' => 'TE CMPN - B']);

        // ID = 7
        Classroom::create(['name' => 'FE ETRX - A']);

        // ID = 8
        Classroom::create(['name' => 'FE ETRX - B']);

        // ID = 9
        Classroom::create(['name' => 'FE BIOMED - A']);


        $data = [
            ['department_id' => 1, 'classroom_id' => 1],
            ['department_id' => 1, 'classroom_id' => 2],
            ['department_id' => 1, 'classroom_id' => 3],
            ['department_id' => 1, 'classroom_id' => 4],
            ['department_id' => 1, 'classroom_id' => 5],
            ['department_id' => 1, 'classroom_id' => 6],
            ['department_id' => 1, 'classroom_id' => 7],
            ['department_id' => 1, 'classroom_id' => 8],
            ['department_id' => 1, 'classroom_id' => 9],
        ];

        DepartmentClassroom::insert($data);
    }
}
