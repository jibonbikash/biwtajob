<?php

namespace App\Imports;

use App\Models\ExamlevelGroup;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportExamlevelGroup implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExamlevelGroup([
            'examlevel_id' => $row[0],
            'name' => $row[1],
            'status' => $row[2],
        ]);
    }
}
