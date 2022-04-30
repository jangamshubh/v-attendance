<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;
use App\Models\ClassroomBatch;
class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ID = 1
        Batch::create(['name' => 'Batch - 1']);

        // ID = 2
        Batch::create(['name' => 'Batch - 2']);

        // ID = 3
        Batch::create(['name' => 'Batch - 3']);

        // ID = 4
        Batch::create(['name' => 'Batch - 1']);

        // ID = 5
        Batch::create(['name' => 'Batch - 2']);

        // ID = 6
        Batch::create(['name' => 'Batch - 3']);

        // ID = 7
        Batch::create(['name' => 'Batch - 1']);

        // ID = 8
        Batch::create(['name' => 'Batch - 2']);

        // ID = 9
        Batch::create(['name' => 'Batch - 3']);

        // ID = 10
        Batch::create(['name' => 'Batch - 1']);

        // ID = 11
        Batch::create(['name' => 'Batch - 2']);

        // ID = 12
        Batch::create(['name' => 'Batch - 3']);

        // ID = 13
        Batch::create(['name' => 'Batch - 1']);

        // ID = 14
        Batch::create(['name' => 'Batch - 2']);

        // ID = 15
        Batch::create(['name' => 'Batch - 3']);

        // ID = 16
        Batch::create(['name' => 'Batch - 1']);

        // ID = 17
        Batch::create(['name' => 'Batch - 2']);

        // ID = 18
        Batch::create(['name' => 'Batch - 3']);



        $data = [
            ['classroom_id' => 1, 'batch_id' => 1],
            ['classroom_id' => 1, 'batch_id' => 2],
            ['classroom_id' => 1, 'batch_id' => 3],

            ['classroom_id' => 2, 'batch_id' => 4],
            ['classroom_id' => 2, 'batch_id' => 5],
            ['classroom_id' => 2, 'batch_id' => 6],

            ['classroom_id' => 3, 'batch_id' => 7],
            ['classroom_id' => 3, 'batch_id' => 8],
            ['classroom_id' => 3, 'batch_id' => 9],

            ['classroom_id' => 4, 'batch_id' => 10],
            ['classroom_id' => 4, 'batch_id' => 11],
            ['classroom_id' => 4, 'batch_id' => 12],

            ['classroom_id' => 5, 'batch_id' => 13],
            ['classroom_id' => 5, 'batch_id' => 14],
            ['classroom_id' => 5, 'batch_id' => 15],

            ['classroom_id' => 6, 'batch_id' => 16],
            ['classroom_id' => 6, 'batch_id' => 17],
            ['classroom_id' => 6, 'batch_id' => 18],
        ];

        ClassroomBatch::insert($data);
    }
}
