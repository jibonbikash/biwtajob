<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantPracticalExport;
use App\Http\Controllers\Controller;
use App\Imports\ApplicantPracticalImport;
use App\Models\ApplicantMedical;
use App\Models\ApplicantPractical;
use App\Models\Job;
use Illuminate\Http\Request;
use Excel;
class PracticalController extends Controller
{
    public function index(Request $request){
        $job= Job::groupBy('job_id')->get()->pluck('job_id', 'job_id');
        $job_id=$request->input('job_id') ?? null;
        $applicants= ApplicantPractical::with(['applicant','job'])
            ->when($job_id, function ($query) use ($job_id){
                $query->where('job_id', $job_id);
            })
            ->latest()->paginate(50);
        return view('admin.jobs.applicant_practical', ['applicants' => $applicants,'jobs'=>$job]);
    }

    public function import(Request $request){
        if($request->type=='New'){
            @ApplicantPractical::where('job_id',$request->input('job_id'))->delete();
        }
        Excel::import(new ApplicantPracticalImport($request->all()), $request->fileimport);
        return redirect()->route('Applicantpractical')->with('success', 'Imported Successfully');

    }

    public function export(Request $request){
        return Excel::download(new ApplicantPracticalExport($request->all()), 'applicants_practical.'.date("Y-m-d").'.xlsx');
    }
}
