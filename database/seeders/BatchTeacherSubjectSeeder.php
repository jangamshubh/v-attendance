<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BatchTeacherSubject;
class BatchTeacherSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Assign CCL Teacher to Chemistry Lectures
            ['batch_id' => 13, 'teacher_id' => 4, 'subject_id' => 3],
            ['batch_id' => 14, 'teacher_id' => 4, 'subject_id' => 3],
            ['batch_id' => 15, 'teacher_id' => 4, 'subject_id' => 3],
            ['batch_id' => 16, 'teacher_id' => 4, 'subject_id' => 3],
            ['batch_id' => 17, 'teacher_id' => 4, 'subject_id' => 3],
            ['batch_id' => 18, 'teacher_id' => 4, 'subject_id' => 3],

            // Assign CCL Teacher to Chemistry Labs
            ['batch_id' => 13, 'teacher_id' => 4, 'subject_id' => 8],
            ['batch_id' => 14, 'teacher_id' => 4, 'subject_id' => 8],
            ['batch_id' => 15, 'teacher_id' => 4, 'subject_id' => 8],
            ['batch_id' => 16, 'teacher_id' => 4, 'subject_id' => 8],
            ['batch_id' => 17, 'teacher_id' => 4, 'subject_id' => 8],
            ['batch_id' => 18, 'teacher_id' => 4, 'subject_id' => 8],
        ];
        BatchTeacherSubject::insert($data);
    }
}
