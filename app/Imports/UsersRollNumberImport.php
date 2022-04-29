<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
class UsersRollNumberImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $user = User::where('email',$row[0])->first();
            if($user) {
                $user->contact_email = $row[1];
                $user->roll_number = $row[2];
                $user->update();
            }
        }
    }
}
