<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobCreateRequest;
use App\Http\Requests\JobUpdateRequest;

use App\Models\Applicant;
use App\Models\Crtificate;
use App\Models\Examlevel;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\JobCertificate;
use App\Models\JobExam;
use App\Models\JobExamSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Query\JoinClause;
use Maatwebsite\Excel\Facades\Excel;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $status= $request->input('status');
       $q= $request->input('q');
       $jobs= Job::withCount(['applicants'])->with(['applicants'])
       ->when($status, function ($query) use ($status){
        $query->where('status', $status);
    })
    ->when($q, function ($query) use ($q){
        $query->where('title', 'like', '%'.$q.'%');
    })
       ->latest()->paginate(20);
     //  dd($jobs);
        return view('admin.jobs.index',['jobs'=>$jobs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $examLevels= Examlevel::get()->pluck('name', 'name');
        return view('admin.jobs.create',['examLevels'=>$examLevels]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobCreateRequest $request)
    {
         //  dd($request->all());
      //  dd(count((array)$request->input('JSC')));
      //  dd(count($request->input('JSC') > 0));

        try {
            DB::beginTransaction();

            try {

                $newJob = Job::create([
                    'uuid' => (string)Str::orderedUuid(),
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'vacancies' => $request->input('vacancies'),
                    'job_id' => $request->input('job_id'),
                    'circular_no' => $request->input('circular_no'),
                    'age_calculation' => $request->input('age_calculation'),
                    'jobcurbday' => $request->input('jobcurbday'),
                    'apply_fee' => $request->input('apply_fee'),
                    'application_deadline' => $request->input('application_deadline'),
                    'job_experience' => $request->input('job_experience'),
                    'job_location' => $request->input('job_location'),
                    'freedom_age' => $request->input('freedom_age'),
                    'handicapped_age' => $request->input('handicapped_age'),
                    'divisioncaplicant_age' => $request->input('divisioncaplicant_age'),
                    'max_age' => $request->input('max_age'),
                    'min_age' => $request->input('min_age'),
                    'freedom_fighter' => $request->input('freedom_fighter'),
                    'petition_age' => $request->input('petition_age'),
                    'salary_range' => $request->input('salary_range'),
                    'min_education' => $request->input('min_education'),
                    'min_education_con' => $request->input('min_education_con'),
                    'min_education_with' => $request->input('min_education_with'),
                    'jsc' => $request->input('JSCExam') == 'JSC' ? true : false,
                    'ssc' => $request->input('SSCExam') == 'SSC' ? true : false,
                    'hsc' => $request->input('HSCExam') == 'HSC' ? true : false,
                    'graduation' => $request->input('GradExam') == 'graduation' ? true : false,
                    'masters' => $request->input('MastersExam') == 'Masters' ? true : false,
                    'certificate_isrequired' => $request->input('certificate_isrequired') == '1' ? true : false,
                    'certificate' => $request->input('certificates') == 'YES' ? "YES" : "NO",
                    'certificate_text' => $request->input('certificate_text'),
                    'related_experience_text' => $request->input('related_experience_text'),
                    'related_experience' => $request->input('related_experience'),
                    'repetition' => $request->input('repetition'),
                    'minimum_job_experience' => $request->input('minimum_job_experience'),
                    'status' => $request->input('status'),
                ]);
                if (count((array)$request->input('JSC')) > 0) {
                    foreach ($request->input('JSC') as $key => $value) {
                        JobExam::create([
                            'job_id' => $newJob->id,
                            'examlevel_group_id' => $value,
                            'type' => 'jsc',
                        ]);
                    }
                }
                if (count((array)$request->input('SSC')) > 0) {
                    foreach ($request->input('SSC') as $key => $value) {
                        JobExam::create([
                            'job_id' => $newJob->id,
                            'examlevel_group_id' => $value,
                            'type' => 'ssc',
                        ]);
                    }
                }

                if (count((array)$request->input('HSC')) > 0) {
                    foreach ($request->input('HSC') as $key => $value) {
                        JobExam::create([
                            'job_id' => $newJob->id,
                            'examlevel_group_id' => $value,
                            'type' => 'hsc',
                        ]);
                    }
                }
                if (count((array)$request->input('Grad')) > 0) {
                    foreach ($request->input('Grad') as $key => $value) {
                        JobExam::create([
                            'job_id' => $newJob->id,
                            'examlevel_group_id' => $value,
                            'type' => 'grad',
                        ]);
                    }
                }
                if (count((array)$request->input('Masters')) > 0) {
                    foreach ($request->input('Masters') as $key => $value) {
                        JobExam::create([
                            'job_id' => $newJob->id,
                            'examlevel_group_id' => $value,
                            'type' => 'masters',
                        ]);
                    }
                }
                if (count((array)$request->input('certificateslist')) > 0) {
                    foreach ($request->input('certificateslist') as $key => $value) {
                        JobCertificate::create([
                            'job_id' => $newJob->id,
                            'certificate_id' => $value,
                        ]);
                    }
                }

                DB::commit();
                if ($newJob) {
                    return redirect()->route('jobs.index')
                        ->with('success', 'Data save successfully!!');
                }
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }


        } catch (\Exception $e) {

            return $e->getMessage();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job=Job::find($id);
        $examLevels= Examlevel::get()->pluck('name', 'name');
        return view('admin.jobs.update',['job'=>$job,'examLevels'=>$examLevels]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobUpdateRequest $request, $id)
    {
       // dd($request->all());
        try {

            $update= Job::where('id', $id)
            ->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'vacancies' => $request->input('vacancies'),
                'job_id' => $request->input('job_id'),
                'circular_no' => $request->input('circular_no'),
                'age_calculation' => $request->input('age_calculation'),
                'jobcurbday' => $request->input('jobcurbday'),
                'apply_fee' => $request->input('apply_fee'),
                'application_deadline' => $request->input('application_deadline'),
                'job_experience' => $request->input('job_experience'),
                'job_location' => $request->input('job_location'),
                'freedom_age' => $request->input('freedom_age'),
                'handicapped_age' => $request->input('handicapped_age'),
                'divisioncaplicant_age' => $request->input('divisioncaplicant_age'),
                'max_age' => $request->input('max_age'),
                'min_age' => $request->input('min_age'),
                'freedom_fighter' => $request->input('freedom_fighter'),
                'petition_age' => $request->input('petition_age'),
                'salary_range' => $request->input('salary_range'),
                'min_education' => $request->input('min_education'),
                'min_education_con' => $request->input('min_education_con'),
                'min_education_with' => $request->input('min_education_with'),
                'jsc' => $request->input('JSCExam') == 'JSC' ? true : false,
                'ssc' => $request->input('SSCExam') == 'SSC' ? true : false,
                'hsc' => $request->input('HSCExam') == 'HSC' ? true : false,
                'graduation' => $request->input('GradExam') == 'graduation' ? true : false,
                'masters' => $request->input('MastersExam') == 'Masters' ? true : false,
                'certificate_isrequired' => $request->input('certificate_isrequired') == '1' ? true : false,
                    'certificate' => $request->input('certificates') == 'YES' ? "YES" : "NO",
                    'certificate_text' => $request->input('certificate_text'),
                    'related_experience_text' => $request->input('related_experience_text'),
                    'related_experience' => $request->input('related_experience'),
                    'repetition' => $request->input('repetition'),
                    'minimum_job_experience' => $request->input('minimum_job_experience'),
                    'graduation_result' => $request->input('Graduation_grade'),
                    'masters_result' => $request->input('Masters_grade'),
                    'status' => $request->input('status'),
            ]);
        if ($update) {
            if (count((array)$request->input('certificateslist')) > 0) {
                foreach ($request->input('certificateslist') as $key => $value) {
                    JobCertificate::create([
                        'job_id' => $id,
                        'certificate_id' => $value,
                    ]);
                }
            }

            return redirect()->route('jobs.index')
                ->with('success', 'Data update successfully!!');
        }

          } catch (\Exception $e) {

              return $e->getMessage();
          }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function imageupload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    // 'apliyedJob'=>function($q) use($code ){
     //   return $q->where('token','like', '%'.$code.'%');
   // }
    public function applicants(Request $request)
    {

       // dd($applicants);
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
        DB::enableQueryLog();
        $applicants=Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','apliyedJob'])
            ->whereNull('deleted_at')
           // ->whereNull('job_applies.deleted_at')
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
            // ->when($certification, function ($query) use ($certification){
            //     $query->where('applicant_certificates.edu_level', $certification);
            // })
            ->when($minimum_age, function ($query) use ($minimum_age){
                $query->where('applicants.age', '>=', $minimum_age);
            })

            ->when($maximum_age, function ($query) use ($maximum_age){
                $query->where('applicants.age', '<=', $maximum_age);
            })

            // ->when($education, function ($query) use ($education){
            //     $query->where('applicant_educations.edu_level', $education);
            // })

            ->when($code, function ($query) use ($code){
                $query->where(function ($query) use ($code){
                    $query->where('job_applies.token','like', '%'.$code.'%')
                        ->orWhere('job_applies.txnid', 'like', '%'.$code.'%')
                        ->orWhere('job_applies.roll', 'like', '%'.$code.'%');

                });

                $query->where('token','like', '%'.$code.'%');
            })

            ->whereIn('applicants.eligible',[0,1,2])
            ->latest()->paginate(50);
      //  dd($applicants);
        /*
        $applicants = DB::table('applicants')
            ->join('job_applies', 'applicants.id', '=', 'job_applies.applicants_id')
            ->join('jobs', function (JoinClause $join) {
            $join->on('applicants.job_id', '=', 'jobs.id')->on('job_applies.job_id', '=', 'jobs.id');
        })
        ->join('applicant_certificates', function (JoinClause $join) {
            $join->on('applicants.job_id', '=', 'applicant_certificates.job_id')->on('applicants.id', '=', 'applicant_certificates.applicants_id');
        })
             ->leftJoin('district_upozilla', function (JoinClause $join) {
                $join->on('applicants.pr_zilla', '=', 'district_upozilla.id');
            })

            ->leftJoin('district_upozilla as upozilla', function (JoinClause $join) {
                $join->on('applicants.pr_upozilla', '=', 'upozilla.id');
            })
            ->leftJoin('district_upozilla as permanent', function (JoinClause $join) {
                $join->on('applicants.bplace', '=', 'permanent.id');
            })

       //     ->leftJoin('district_upozilla', 'applicants.pr_zilla', '=', 'district_upozilla.id')
        //    ->leftJoin('district_upozilla as upozilla', 'applicants.pr_upozilla', '=', 'upozilla.id')
      //  ->join('applicant_educations', 'applicants.id', '=', 'applicant_educations.applicants_id')

        // ->join('applicant_educations', function (JoinClause $join) {
        //     $join->on('applicants.job_id', '=', 'applicant_educations.job_id')->on('applicants.id', '=', 'applicant_educations.applicants_id');
        // })
            ->select('applicants.*', 'job_applies.token', 'jobs.title as job_title', 'job_applies.received as received', 'job_applies.txnid as txnid', 'job_applies.txndate as txndate', 'job_applies.roll as roll',
            'job_applies.exam_hall as exam_hall','job_applies.exam_date as exam_date','job_applies.exam_time as exam_time', 'job_applies.exam_time as apply_date',
            'jobs.age_calculation as age_calculation', 'applicant_certificates.applicants_id','district_upozilla.zilla_name as zilla_name',
           'upozilla.upozilla as upozilla_name', 'permanent.zilla_name as permanentzilla_name'
            )
            ->whereNull('applicants.deleted_at')
            ->whereNull('job_applies.deleted_at')
            ->when($request->input('q'), function ($q) use ($request){
                $q->where(function ($query) use ($request){
                    $query->where('applicants.name_en','like', '%'.$request->input('q').'%')
                        ->orWhere('applicants.name_bn', 'like', '%'.$request->input('q').'%')
                        ->orWhere('applicants.nid', 'like', '%'.$request->input('q').'%')
                        ->orWhere('applicants.mobile', 'like', '%'.$request->input('q').'%');
            });
            })
            ->when($job_id, function ($query) use ($job_id){
                $query->where('applicants.job_id', $job_id);
            })
            ->when($gender, function ($query) use ($gender){
                $query->where('applicants.gender', $gender);
            })
            ->when($religion, function ($query) use ($religion){
                $query->where('applicants.religious', $religion);
            })
            ->when($quota, function ($query) use ($quota){
                $query->where('applicants.quota', $quota);
            })
            ->when($experience, function ($query) use ($experience){
                $query->where('applicants.experienceyear', $quota);
            })
            // ->when($certification, function ($query) use ($certification){
            //     $query->where('applicant_certificates.edu_level', $certification);
            // })
            ->when($minimum_age, function ($query) use ($minimum_age){
                $query->where('applicants.age', '>=', $minimum_age);
            })

            ->when($maximum_age, function ($query) use ($maximum_age){
                $query->where('applicants.age', '<=', $maximum_age);
            })

            // ->when($education, function ($query) use ($education){
            //     $query->where('applicant_educations.edu_level', $education);
            // })

            ->when($code, function ($query) use ($code){
                $query->where(function ($query) use ($request){
                    $query->where('job_applies.token','like', '%'.$code.'%')
                        ->orWhere('job_applies.txnid', 'like', '%'.$code.'%')
                        ->orWhere('job_applies.roll', 'like', '%'.$code.'%');

            });

                $query->where('token','like', '%'.$code.'%');
            })

            ->whereIn('applicants.eligible',[1,2])
          //  ->groupBy('applicants.id','applicant_certificates.applicants_id')
            ->latest()->paginate(50);
        */
          //  dd(DB::getQueryLog());
//dd($applicants);
        return view('admin.jobs.applicants', ['applicants' => $applicants, 'jobs'=>$job,'jobAll'=>$jobAll]);
    }
    public function rollSetting(Request $request){
        $job= Job::get()->pluck('title', 'id');

        return view('admin.jobs.rollSetting', ['jobs'=>$job]);
    }
    public function seatPlan(Request $request){

        $job= Job::get()->pluck('title', 'id');
        $jobIDs = Job::groupBy('job_id')->get()->pluck('job_id', 'job_id');
        $job_id=$request->input('job_id') ?? null;
        $applicationinfo = Applicant::with(['job','apliyedJob'])->
                whereHas('apliyedJob', function ($query) {
                    $query->whereNotNull('roll')->whereNotNull('exam_hall')
                        ->whereNotNull('exam_date')->whereNotNull('exam_time');
                })
            ->when($job_id, function ($query) use ($job_id){
                $query->where('job_id', $job_id);
            })
                ->orderBy('id','desc')->paginate(50);
        return view('admin.jobs.seatPlan', ['jobs'=>$job, 'jobID'=>$jobIDs,'applicationinfos'=>$applicationinfo]);
    }

    public function educationtype(Request $request)
    {
        $examlevel = Examlevel::with(['examGroups'])->where('name', $request->type)->first();

        if ($examlevel) {
            if (count($examlevel->examGroups) > 0) {

                $view = view('admin.jobs._education', ['examlevel'=>collect($examlevel->examGroups)->pluck('name','id')])->render();
                return response()->json(['success' => true, 'data' => $view]);

            } else {

                return response()->json(['success' => false, 'data' => []]);
            }

        }

      // dd($examlevel);
        //return $request->all();
    }

    public function setting(Request $request, $uuid)
    {

        $joninfo = Job::active()->with(['examSubject'])->where('uuid', $uuid)->first();
      //  dd($joninfo);
        return view('admin.jobs.setting',['joninfo'=>$joninfo]);
    }
    public function settingSave(Request $request, $uuid){
        dd($request->all());

    }


    public function examsubject(Request $request)
    {

        DB::beginTransaction();

        try {
            @JobExamSubject::where([
                'job_id' => $request->input('job_id'),
                'type' => $request->input('type'),
                'examlevel_group_id' => $request->input('examlevel_group_id'),
            ])->delete();
            foreach ($request->input('examlevelSubject') as $subject) {
                JobExamSubject::create([
                    'job_id' => $request->input('job_id'),
                    'type' => $request->input('type'),
                    'examlevel_group_id' => $request->input('examlevel_group_id'),
                    'examlevel_subject_id' => $subject,
                ]);
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false]);
        }



    }

    public function certificateslist(){
       $certificates= Crtificate::orderBy('name','ASC')->get();
       //$certificates= Crtificate::orderBy('name','ASC')->pluck('name','id');
        $view = view('admin.jobs._certificateslist', ['certificates'=>$certificates])->render();
        return response()->json(['success' => true, 'data' => $view]);
    }

    public function adminCard(Request $request, $id)
    {
        $applicationinfo = Applicant::with(['educations', 'job', 'birthplace', 'zila', 'upozilla', 'permanentzila', 'permanentupozilla', 'apliyedJob'])->find($id);
        // dd($applicationinfo);
        if ($applicationinfo->eligible == 2) {
            return view('layouts.print', [
                'appliedddata' => $applicationinfo,
            ]);
        } else {
            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }
public function printCopy(Request $request, $id){


        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','apliyedJob'])->find($id);

       if($applicationinfo->eligible==1 || $applicationinfo->eligible==2){
        return view('jobs.applicantionPrint',[
            'applicationinfo'=>$applicationinfo,
          ]);
       }
       else{
        return redirect()->route('home')
        ->with('error', 'No data found!!!');;
       }


}

    public function rollSettingconfigure(Request $request)
    {

        $request->validate([
            'job_id' => 'required|numeric|min:1',
            'rollstart' => 'required|numeric|min:1',
            'examdate' => 'required',
            'examtime' => 'required',
        ]);

        try {


            DB::beginTransaction();

            try {
                $rollStart = $request->input('rollstart');
                $total=0;
                $applyApplicants = JobApply::where('job_id', $request->input('job_id'))->where('received', 2)->get();
                foreach ($applyApplicants as $applyApplicant) {
                    $applyApplicant->roll = $rollStart;
                    $applyApplicant->exam_date = $request->input('examdate');
                    $applyApplicant->exam_time = $request->input('examtime');
                    $applyApplicant->save();
                    $rollStart++;
                    $total++;
                }

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();

            }


            return redirect()->route('rollSetting')
                ->with('success', 'Total ' . $total . ' data updated');;

        } catch (\Exception $e) {

            return redirect()->route('rollSetting')
                ->with('error', $e->getMessage());
        }


        /*    JobApply::where('job_id',$request->input('job_id'))
        ->increment('roll', 1, ['exam_date' => $request->input('examdate'), 'exam_time' => $request->input('examtime')]);
        */
    }

public function seatPlansetting(Request $request){

    $request->validate([
        'job_id' => 'required|numeric|min:1',
        'rollstart' => 'required|numeric|min:1',
        'rollend' => 'required|numeric|min:1',
        'institute' => 'required'
    ]);

    try {
        DB::beginTransaction();

        try {

            $applyApplicants=JobApply::where('job_id',$request->input('job_id'))->where('received',2)->whereBetween('roll', [$request->input('rollstart'), $request->input('rollend')])->get();
         //   dd($applyApplicants);
            foreach ( $applyApplicants as $applyApplicant) {
                $applyApplicant->exam_hall=$request->input('institute');
                $applyApplicant->save();

            }

            DB::commit();

            return redirect()->route('seatPlan')
            ->with('success', 'Total '.$request->input('rollstart'). ' to '.$request->input('rollend'). ' data updated');;

        } catch (\Exception $e) {
            DB::rollback();

        }

    } catch (\Exception $e) {

        return redirect()->route('seatPlan')
        ->with('error', $e->getMessage());
      }

    //return redirect()->route('seatPlan');

}

    public function seatPlansettingRoll(Request $request)
    {

        $data = DB::table('job_applies')
            ->select(\DB::raw('MIN(roll) AS rollStart, MAX(roll) AS rollEnd'))
            ->where('job_id', $request->input('job_id'))
            ->whereNotNull('exam_date')
            ->whereNotNull('exam_time')
            ->whereNull('exam_hall')
            ->first();
        //dd($data);
        if ($data) {

            return response()->json(['success' => true, 'data' => $data]);
        } else
            return response()->json(['success' => false, 'message' => 'SeatPlan already complete or no roll setting yet.']);
        // dd($data);

    }

    public function exportApplicants(Request $request)
    {
        return Excel::download(new ApplicantExport($request->all()), 'applicants.xlsx');
    }




}
