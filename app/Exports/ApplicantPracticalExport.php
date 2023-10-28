<?php

namespace App\Exports;

use App\Models\ApplicantPractical;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ApplicantPracticalExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $job_id=$request['job_id'] ?? null;
        $applicants= ApplicantPractical::with(['applicant','job'])
            ->when($job_id, function ($query) use ($job_id){
                $query->where('job_id', $job_id);
            })->latest()->paginate(50);
        return view('exports.applicants_practical', [
            'applicants' =>$applicants
        ]);
    }

}
