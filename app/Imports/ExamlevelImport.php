<?php

namespace App\Imports;

use App\Models\Examlevel;
use Maatwebsite\Excel\Concerns\ToModel;

class ExamlevelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Examlevel([
            'name'=>$row[0],
            'status'=>1,
        ]);
    }
}
