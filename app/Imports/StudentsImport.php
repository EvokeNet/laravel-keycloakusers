<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Todo: Configure unique indexes
        $student = Student::where('email', $row['email'])->where('campaign_id', $row['campaign_id'])->first();

        if ($student) {
            return $student;
        }

        return new Student([
            'campaign_id' => $row['campaign_id'],
            'group_id' => $row['group_id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
        ]);
    }
}
