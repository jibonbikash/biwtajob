<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCreateRequest;
use App\Models\Examlevel;
use App\Models\Job;
use App\Models\JobExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $jobs= Job::withCount(['applicants'])->with(['applicants'])->latest()->paginate(20);
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
        return view('admin.jobs.create');
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
                    'age_calculation' => $request->input('age_calculation'),
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
                    'jsc' => $request->input('JSCExam') == 'JSC' ? true : false,
                    'ssc' => $request->input('SSCExam') == 'SSC' ? true : false,
                    'hsc' => $request->input('HSCExam') == 'HSC' ? true : false,
                    'graduation	' => $request->input('GradExam') == 'Grad' ? true : false,
                    'masters	' => $request->input('MastersExam') == 'Masters' ? true : false,
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
        return view('admin.jobs.update',['job'=>$job]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function applicants(Request $request){
        return view('admin.jobs.applicants');
    }
    public function rollSetting(Request $request){
        return view('admin.jobs.rollSetting');
    }
    public function seatPlan(Request $request){
        return view('admin.jobs.seatPlan');
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

}
