<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantExport;
use App\Exports\ApplicantVivaExport;
use App\Http\Controllers\Controller;
use App\Imports\ApplicantVivaImport;
use App\Models\Applicant;
use App\Models\ApplicantViva;
use App\Models\Job;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VivaController extends Controller
{

    public function index(Request $request)
    {
        $job = Job::groupBy('job_id')->get()->pluck('job_id', 'job_id');
        $job_id = $request->input('job_id') ?? null;
        $applicants = ApplicantViva::with(['applicant', 'job'])
            ->when($job_id, function ($query) use ($job_id) {
                $query->where('job_id', $job_id);
            })->latest()->paginate(50);
        return view('admin.jobs.applicant_viva', ['applicants' => $applicants, 'jobs' => $job]);
    }

    public function import(Request $request){
       // dd($request->all());
        if($request->type=='New'){
            @ApplicantViva::where('job_id',$request->input('job_id'))->delete();
        }
        Excel::import(new ApplicantVivaImport($request->all()), $request->fileimport);
        return redirect()->route('ApplicantViva')->with('success', 'Imported Successfully');

    }

    public function exportApplicants(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new ApplicantVivaExport($request->all()), 'applicants_Viva.'.date("Y-m-d").'.xlsx');

    }

    public function joblist(Request $request)
    {
        $job= Job::select('id', 'title')->where('job_id', $request->cercularID)->get();
        return $job;
    }
    public function vivasetting(Request $request){

        $request->validate([
            'job_cercularID' => 'required|exists:jobs,job_id',
            'job_id' => 'required|exists:jobs,id',
            'rollstart' => 'required|integer',
            'rollend' => 'required|integer|gte:rollstart',
            'date' => 'required',
            'time' => 'required',
            'place' => 'required',
        ]);
        DB::beginTransaction();
        try {
//            $applicationinfo= Applicant::whereHas('apliyedJob')->with('apliyedJob','viva')->where([
//                'uuid'=> $uuid,
//                'eligible'=> 2,
//            ])->whereHas('viva')->first();

            $applyApplicants=ApplicantViva::where('job_id',$request->input('job_id'))->whereBetween('roll', [$request->input('rollstart'), $request->input('rollend')])->update([
                "date"=>$request->input('date'),
                "time"=>$request->input('time'),
                "place"=>$request->input('place'),
            ]);
            DB::commit();
            return redirect()->route('ApplicantViva')->with('success', 'Viva setting Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::info(json_encode($e->getMessage()));
            return $e->getMessage();
        }


dd($request->all());
    }
}
