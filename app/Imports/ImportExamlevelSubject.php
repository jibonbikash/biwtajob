<?php

namespace App\Imports;

use App\Models\ExamlevelSubject;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportExamlevelSubject implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExamlevelSubject([
            'examlevel_id' => $row[0],
            'examlevel_group_id' => $row[1],
            'name' => $row[2],
            'status' => $row[3],
        ]);
    }
}
