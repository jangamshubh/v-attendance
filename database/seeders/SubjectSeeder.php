<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ID = 1
        Subject::create(['name' => 'Applied Mathematics - II', 'code' => 'FEC201']);

        // ID = 2
        Subject::create(['name' => 'Applied Physics - II', 'code' => 'FEC202']);

        // ID = 3
        Subject::create(['name' => 'CCL', 'code' => 'FEC203']);

        // ID = 4
        Subject::create(['name' => 'Engineering Graphics', 'code' => 'FEC204']);

        // ID = 5
        Subject::create(['name' => 'C Programming', 'code' => 'FEC205']);

        // ID = 6
        Subject::create(['name' => 'Professional Communication & Ethics', 'code' => 'FEC206']);

        // ID = 7
        Subject::create(['name' => 'Applied Physics - II Lab', 'code' => 'FEL201']);

        // ID = 8
        Subject::create(['name' => 'CCL Lab', 'code' => 'FEL202']);

        // ID = 9
        Subject::create(['name' => 'Engineering Graphics Lab', 'code' => 'FEL203']);

        // ID = 10
        Subject::create(['name' => 'C Programming Lab', 'code' => 'FEL204']);

        // ID = 11
        Subject::create(['name' => 'Professional Communication & Ethics Lab', 'code' => 'FEL205']);

        // ID = 12
        Subject::create(['name' => 'Basic Workshop Practice - II', 'code' => 'FEL206']);
    }
}
