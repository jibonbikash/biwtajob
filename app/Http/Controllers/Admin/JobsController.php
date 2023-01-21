<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCreateRequest;
use App\Models\Job;
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
                ]);

                DB::commit();
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
}
