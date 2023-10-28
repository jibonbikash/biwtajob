<?php

namespace App\Imports;

use App\Models\ApplicantViva;
use App\Models\JobApply;
use Maatwebsite\Excel\Concerns\ToModel;

class ApplicantVivaImport implements ToModel
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
       $roll=JobApply::where([
           'job_id'=>$job_id,
           'roll'=>$row[0]
       ])->first();
     //  dd($roll);
        return new ApplicantViva([
            'applicant_id' =>$roll ? $roll->applicants_id:null,
            'job_id' => $job_id,
            'roll' => $roll ? $roll->roll:null,
//            'date' => is_null($row[1]) ? null: $row[1],
//            'place' => is_null($row[2]) ? null: $row[2],
//            'roll' => is_null($row[2]) ? null: $row[2],
        ]);
    }
}
