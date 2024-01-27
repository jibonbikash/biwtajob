<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ApplicantEligibleImport;
use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
class EligibleController extends Controller
{
    public function index(Request $request){

        $job= Job::groupBy('job_id')->get()->pluck('job_id', 'job_id');
        $jobAll= Job::get()->pluck('title', 'id');
        $q=$request->input('q') ?? null;
        $job_id=$request->input('job_id') ?? null;
        $code=$request->input('code') ?? null;
        $gender=$request->input('gender') ?? null;
        $religion=$request->input('religion') ?? null;
        $education=$request->input('education') ?? null;
        $minimum_age=$request->input('minimum_age') ?? null;
        $maximum_age=$request->input('maximum_age') ?? null;
        $experience=$request->input('experience') ?? null;
        $certification=$request->input('certification') ?? null;
        $quota=$request->input('quota') ?? null;
      //  DB::enableQueryLog();
        $applicants=Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','apliyedJob'])
            ->whereNull('deleted_at')
            ->when($request->input('q'), function ($q) use ($request){
                $q->where(function ($query) use ($request){
                    $query->where('name_en','like', '%'.$request->input('q').'%')
                        ->orWhere('name_bn', 'like', '%'.$request->input('q').'%')
                        ->orWhere('nid', 'like', '%'.$request->input('q').'%')
                        ->orWhere('mobile', 'like', '%'.$request->input('q').'%');
                });
            })
            ->when($job_id, function ($query) use ($job_id){
                $query->where('job_id', $job_id);
            })
            ->when($gender, function ($query) use ($gender){
                $query->where('gender', $gender);
            })
            ->when($religion, function ($query) use ($religion){
                $query->where('religious', $religion);
            })
            ->when($quota, function ($query) use ($quota){
                $query->where('quota', $quota);
            })
            ->when($experience, function ($query) use ($experience){
                $query->where('experienceyear', $experience);
            })
            ->when($minimum_age, function ($query) use ($minimum_age){
                $query->where('applicants.age', '>=', $minimum_age);
            })

            ->when($maximum_age, function ($query) use ($maximum_age){
                $query->where('applicants.age', '<=', $maximum_age);
            })
//            ->when($code, function ($query) use ($code){
//                $query->whereRaw('jb18_job_applies.token',  $code);
//            })
//            ->when($code, function ($query) use ($code){
//                $query->where(function ($query) use ($code){
//                    $query->where('apliyedJob.token','like', '%'.$code.'%')
//                        ->where('apliyedJob.txnid', 'like', '%'.$code.'%')
//                        ->orWhere('apliyedJob.roll', 'like', '%'.$code.'%');
//
//                });
//
//               // $query->where('token','like', '%'.$code.'%');
//            })

            ->whereIn('applicants.eligible',[2])
            ->latest()->paginate(50);
       // dd($applicants);
        return view('admin.jobs.eligible', ['applicants' => $applicants, 'jobs'=>$job, 'jobAll'=>$jobAll]);
    }

    public function import(Request $request){

//        if($request->type=='New'){
//            Applicant::where('job_id',$request->input('job_id'))->where('eligible',2)->update(['eligible'=>1]);
//        }
        Excel::import(new ApplicantEligibleImport($request->all()), $request->fileimport);
        return redirect()->route('applicant.eligible')->with('success', 'Imported Successfully');
    }
}
