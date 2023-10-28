<?php

namespace App\Imports;

use App\Models\Board;
use Maatwebsite\Excel\Concerns\ToModel;

class UnivercityImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function model(array $row)
    {
        return new Board([
            'name'=>$row[0],
            'status'=>1,
            'type'=>2,
        ]);
    }
}
