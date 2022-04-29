<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\College;
class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ID = 1
        College::create([
            'name' => 'Vidyalankar Institute of Technology',
            'year_of_establishment' => '1999',
            'aicte_id' => 'NULL',
            'admin_id' => 2,
        ]);
    }
}
