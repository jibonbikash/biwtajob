<?php

namespace App\Exports;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ApplicantSeatPlanExport implements FromView
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

        $job_id = $request['job_id'] ?? null;
        $applicationinfo = Applicant::with(['job', 'apliyedJob', 'birthplace'])
            ->whereHas('apliyedJob', function ($query) {
                $query->whereNotNull('roll')->whereNotNull('exam_hall')
                    ->whereNotNull('exam_date')->whereNotNull('exam_time');
            })
            ->when($job_id, function ($query) use ($job_id) {
                $query->where('job_id', $job_id);
            })
            ->latest()->get();
        $job = Job::find($job_id);
        return view('exports.seatPlan', [
            'applicants' => $applicationinfo,
            'job' => $job,
        ]);
    }

}
