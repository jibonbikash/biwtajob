<?php

namespace App\Imports;

use App\Models\ApplicantMedical;
use Maatwebsite\Excel\Concerns\ToModel;

class ApplicantMedicalImport implements ToModel
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
        $request = $this->request;
        $job_id=$request['job_id'] ?? null;
        return new ApplicantMedical([
            'applicant_id' => $row[0],
            'job_id' => $job_id,
//            'date' => is_null($row[1]) ? null: $row[1],
//            'place' => is_null($row[2]) ? null: $row[2],
//            'roll' => is_null($row[2]) ? null: $row[2],
        ]);
    }
}
