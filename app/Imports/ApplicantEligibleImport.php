<?php

namespace App\Imports;

use App\Models\Applicant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ApplicantEligibleImport implements WithBatchInserts, WithChunkReading, ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
//    public function model(array $row)
//    {
//        return new Applicant([
//            //
//        ]);
//    }
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection(Collection $rows)
    {
        $request = $this->request;
        $job_id=$request['job_id'] ?? null;
        $notEligible=Applicant::whereNotIn('code',$rows)->where('job_id', $job_id)->where('eligible', 1)->get()->pluck('id');
       // dd($notEligible);
        Applicant::whereIn('id',$notEligible)->where('job_id', $job_id)->where('eligible', 1)->update(['eligible'=>2]);
//        foreach ($rows as $row)
//        {
//            Applicant::where([
//                'job_id'=>$job_id,
//                'code'=>$row[0],
//                'eligible'=>1,
//            ])->update(['eligible'=>2]);
//
//        }
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

}
