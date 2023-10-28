<?php

namespace App\Imports;

use App\Models\ExamlevelGroup;
use Maatwebsite\Excel\Concerns\ToModel;

class ExamlevelGroupImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExamlevelGroup([
            'name'=>$row[0],
            'status'=>1,
            'examlevel_id'=>1,
        ]);
    }
}
