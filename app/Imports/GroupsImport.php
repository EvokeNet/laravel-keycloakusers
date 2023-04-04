<?php

namespace App\Imports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GroupsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Todo: Configure unique indexes
        $group = Group::where('name', $row['name'])->where('campaign_id', $row['campaign_id'])->first();

        if ($group) {
            return $group;
        }

        return new Group([
            'campaign_id' => $row['campaign_id'],
            'name' => $row['name'],
            'moodle_groupname' => $row['moodle_groupname'],
            'moodle_courseid' => $row['moodle_courseid']
        ]);
    }
}
