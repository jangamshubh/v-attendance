<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\BatchStudent;
class UsersImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $user = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'roll_number' => $row[2],
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Student');
            $batch_student = BatchStudent::create([
                'student_id' => $user->id,
                'batch_id' => $row[3],
            ]);
        }
    }
}
