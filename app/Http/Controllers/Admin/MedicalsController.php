<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantMedicalExport;
use App\Http\Controllers\Controller;
use App\Imports\ApplicantMedicalImport;
use App\Models\ApplicantMedical;
use App\Models\Job;
use Illuminate\Http\Request;
use Excel;
class MedicalsController extends Controller
{
    public function index(Request $request){
        $job= Job::groupBy('job_id')->get()->pluck('job_id', 'job_id');
        $job_id=$request->input('job_id') ?? null;
        $applicants= ApplicantMedical::with(['applicant','job'])
            ->when($job_id, function ($query) use ($job_id){
                $query->where('job_id', $job_id);
            })
            ->latest()->paginate(50);
        return view('admin.jobs.applicant_medical', ['applicants' => $applicants,'jobs'=>$job]);
    }

    public function import(Request $request){
        if($request->type=='New'){
            @ApplicantMedical::where('job_id',$request->input('job_id'))->delete();
        }
        Excel::import(new ApplicantMedicalImport($request->all()), $request->fileimport);
        return redirect()->route('Applicantmedical')->with('success', 'Imported Successfully');

    }

    public function export(Request $request){
        return Excel::download(new ApplicantMedicalExport($request->all()), 'applicants_medical.'.date("Y-m-d").'.xlsx');
    }

}
