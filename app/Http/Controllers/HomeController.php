<?php

namespace App\Http\Controllers;

use App\Helpers\StaticValue;
use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\Examlevel;
use App\Models\ExamlevelSubject;
use App\Models\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $jobs= Job::active()->activeJobs()->orderBy('id','DESC')->paginate(10);
        return view('home',['jobs'=>$jobs]);
    }
    public function details(Request $request, $uuid){
        try {
            $job= Job::active()->activeJobs()->where('uuid',$uuid)->firstOrFail();
            return view('jobs.details',['job'=>$job]);
        } catch (ModelNotFoundException $e) {

            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }

    public function applyform(Request $request, $uuid){
        try {
            $job= Job::active()->activeJobs()->where('uuid',$uuid)->firstOrFail();
            $district_Upozilla = DB::table('district_upozilla')->orderBy('zilla_name','ASC')->get()->toArray();
            $boards = DB::table('boards')->orderBy('name','ASC')->pluck('name','id');
           $examlist= Examlevel::select('id','name','status')->with(['examGroups'=>function($quert){
               $quert->with(['examSubject'=>function($query){
                   $query->select('id','examlevel_id','examlevel_group_id','name');
               }])->select('id','examlevel_id','name','status');
           }])->get();
         //   dd($district_Upozilla);
          //  dd($examlist);
            return view('jobs.applyform',[
                'job'=>$job,
                'district_Upozilla'=>$district_Upozilla,
                'boards'=>$boards,
                'examlist'=>$examlist,
                'uuid'=>$uuid,
                ]);
        } catch (ModelNotFoundException $e) {

            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }

    public function examSubject(Request $request){

      $subject=  ExamlevelSubject::with(['examGroup','examlevel'])
            ->where([
                ['examlevel_id', $request->exam],
                ['examlevel_group_id', $request->examgroup],
            ])->get();
        return response()->json(['success' => true, 'data' => $subject]);

    }

    public function jobApply(Request $request){



       $job= Job::where('uuid',$request->uuid )->first();
        if($job){

            $validator = Validator::make($request->all(), [
                'uuid' => 'required',
                'name_en' => 'required|max:255',
                'name_bn' => 'required|max:255',
                'father_name' => 'required|max:255',
                'mother_name' => 'required|max:255',
                'date_of_birth' => 'required|max:255',
                'mobile_no' => 'required|max:255',
                'nationality' => 'required|max:255',
                'religion' => 'required|max:255',
                'gender' => 'required|max:255',
                'date_of_place' => 'required|max:255',
                'present_postoffice' => 'required|max:255',
                'present_postcode' => 'required|max:255',
                'present_zilla' => 'required|max:255',
                'present_upozilla' => 'required|max:255',
                'permanent_postoffice' => 'required|max:255',
                'permanent_postcode' => 'required|max:255',
                'permanent_zilla' => 'required|max:255',
                'permanent_upozilla' => 'required|max:255',
                'image' => 'required|mimes:jpeg,png,jpg,gif|max:1024',
                'signature' => 'required|mimes:jpeg,png,jpg,gif|max:1024|dimensions:max_width=300,max_height=300',

            ]);
            $validator->sometimes('jscexamlevel', 'required', function () use ($job){
                return $job->jsc==1;
            });
            $validator->sometimes('jscinstitute_name', 'required', function () use ($job){
                return $job->jsc==1;
            });
            $validator->sometimes('jscresult', 'required', function () use ($job){
                return $job->jsc==1;
            });
            $validator->sometimes('jscboard', 'required', function () use ($job){
                return $job->jsc==1;
            });
            $validator->sometimes('jscpassyear', 'required', function () use ($job){
                return $job->jsc==1;
            });

            $validator->sometimes('sscexamlevel', 'required', function () use ($job){
                return $job->ssc==1;
            });
            $validator->sometimes('sscinstitute_name', 'required', function () use ($job){
                return $job->ssc==1;
            });
            $validator->sometimes('sscresult', 'required', function () use ($job){
                return $job->ssc==1;
            });
            $validator->sometimes('sscSubject', 'required', function () use ($job){
                return $job->ssc==1;
            });
            $validator->sometimes('sscboard', 'required', function () use ($job){
                return $job->ssc==1;
            });
            $validator->sometimes('sscpassyear', 'required', function () use ($job){
                return $job->ssc==1;
            });

            $validator->sometimes('hscexamlevel', 'required', function () use ($job){
                return $job->hsc==1;
            });
            $validator->sometimes('hscinstitute_name', 'required', function () use ($job){
                return $job->hsc==1;
            });
            $validator->sometimes('hscresult', 'required', function () use ($job){
                return $job->hsc==1;
            });
            $validator->sometimes('hscubject', 'required', function () use ($job){
                return $job->hsc==1;
            });
            $validator->sometimes('hscboard', 'required', function () use ($job){
                return $job->hsc==1;
            });
            $validator->sometimes('hscpassyear', 'required', function () use ($job){
                return $job->hsc==1;
            });


            $validator->sometimes('graduationexamlevel', 'required', function () use ($job){
                return $job->graduation==1;
            });
            $validator->sometimes('graduationinstitute_name', 'required', function () use ($job){
                return $job->graduation==1;
            });
            $validator->sometimes('graduationresult', 'required', function () use ($job){
                return $job->graduation==1;
            });
            $validator->sometimes('graduationsubject', 'required', function () use ($job){
                return $job->graduation==1;
            });
            $validator->sometimes('graduationuniversity', 'required', function () use ($job){
                return $job->graduation==1;
            });
            $validator->sometimes('graduationpassyear', 'required', function () use ($job){
                return $job->graduation==1;
            });


            $validator->sometimes('mastersexamlevel', 'required', function () use ($job){
                return $job->masters==1;
            });
            $validator->sometimes('mastersinstitute_name', 'required', function () use ($job){
                return $job->masters==1;
            });
            $validator->sometimes('mastersresult', 'required', function () use ($job){
                return $job->masters==1;
            });
            $validator->sometimes('mastersSubject', 'required', function () use ($job){
                return $job->masters==1;
            });
            $validator->sometimes('mastersuniversity', 'required', function () use ($job){
                return $job->masters==1;
            });
            $validator->sometimes('masterspassyear', 'required', function () use ($job){
                return $job->masters==1;
            });

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
          //  dd($request->all());
           $jobinfo= Job::where('uuid', $request->input('uuid'))->first();

            $image = $request->file('image');
            $signature = $request->file('signature');
            $extension = $image->getClientOriginalExtension();
            $extensionsignature = $signature->getClientOriginalExtension();
            $nameimage = time() . '-' . mt_rand() . "." . $extension;
            $namesignature = time() . '-' . mt_rand() . "_signature." . $extensionsignature;
            StaticValue::createDirecrotory($jobinfo->job_id);
            $image->move(public_path('assets/applicants/'.date("Y").'/'.$jobinfo->job_id), $nameimage);
            $signature->move(public_path('assets/applicants/'.date("Y").'/'.$jobinfo->job_id), $namesignature);
            $nameimage=date("Y").'/'.$jobinfo->job_id.'/'.$nameimage;
            $namesignature=date("Y").'/'.$jobinfo->job_id.'/'.$namesignature;


            DB::beginTransaction();

            try {

                $applicant= Applicant::create([
                    'job_id' => $jobinfo->id,
                    'uuid' => (string)Str::orderedUuid(),
                    'name_bn' => $request->input('name_bn'),
                    'name_en' => $request->input('name_en'),
                    'nid' => $request->input('nid'),
                    'brn' => $request->input('brn'),
                    'bday' => $request->input('date_of_birth'),
                    'bplace' => $request->input('date_of_place'),
                    'father_name' => $request->input('father_name'),
                    'mother_name' => $request->input('mother_name'),
                    'present_addrress' => null,
                    'parmanent_address' => null,
                    'mobile' => $request->input('mobile_no'),
                    'nationality' => $request->input('nationality'),
                    'gender' => $request->input('gender'),
                    'religious' => $request->input('religion'),
                    'extra_qualification' => $request->input('extQualification'),
                    'experience' => $request->input('Experience'),
                    'bank_draft' => '',
                    'bank_draft_date' => '',
                    'bank_details' => '',
                    'division_appli' =>$request->input('divisioncaplicant'),
                    'quota_freedom' => 0,
                    'quota_tribal' => 0,
                    'quota_Handicapped' => 0,
                    'quota_orphanages' => 0,
                    'village_police' => 0,
                    'others_quota' => 0,
                    'quota' => $request->input('quota'),
                    'pa_house' => $request->input('present_house_no'),
                    'pa_village' => $request->input('present_village'),
                    'pa_union' => $request->input('present_union'),
                    'pa_postoffice' => $request->input('present_postoffice'),
                    'pa_postcode' => $request->input('present_postcode'),
                    'pa_upozilla' => $request->input('present_upozilla'),
                    'pa_zilla' => $request->input('present_zilla'),
                    'pr_house' => $request->input('permanent_house_no'),
                    'pr_village' => $request->input('permanent_village'),
                    'pr_union' => $request->input('permanent_union'),
                    'pr_postoffice' => $request->input('permanent_postoffice'),
                    'pr_postcode' => $request->input('permanent_postcode'),
                    'pr_upozilla' => $request->input('permanent_upozilla'),
                    'pr_zilla' => $request->input('permanent_zilla'),
                    'occupation' => $request->input('occupation'),
                    'picture' => $nameimage,
                    'signature' => $namesignature,
                    'job_circular' => '',
                    'experienceyear' => $request->input('experienceyear'),
                    'experiencemonth' => $request->input('experiencemonth'),
                    'age' => '',
                    'code' => '',
                    'eligible' => 0,
                    'jobcurday' => '',
                ]);
                $education=[];
                if($jobinfo->jsc==1){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('jscexamlevel'),
                        'institute_name'=> $request->input('jscinstitute_name'),
                        'group_subject'=> null,
                        'result'=> $request->input('jscresult'),
                        'cgpa'=> $request->input('jscresult_score'),
                        'out_of'=> $request->input('jscresult'),
                        'board_university'=> $request->input('jscboard'),
                        'passing_year'=> $request->input('jscpassyear'),
                    ]);
                }

                if($jobinfo->ssc==1){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('sscexamlevel'),
                        'institute_name'=> $request->input('sscinstitute_name'),
                        'group_subject'=> $request->input('sscSubject'),
                        'result'=> $request->input('sscresult'),
                        'cgpa'=> $request->input('sscresult_score'),
                        'out_of'=> $request->input('sscresult'),
                        'board_university'=> $request->input('sscboard'),
                        'passing_year'=> $request->input('sscpassyear'),
                    ]);

                }

                if($jobinfo->hsc==1){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('hscexamlevel'),
                        'institute_name'=> $request->input('hscinstitute_name'),
                        'group_subject'=> $request->input('hscubject'),
                        'result'=> $request->input('hscresult'),
                        'cgpa'=> $request->input('hscresult_score'),
                        'out_of'=> $request->input('hscresult'),
                        'board_university'=> $request->input('hscboard'),
                        'passing_year'=> $request->input('hscpassyear'),
                    ]);

                }
                if($jobinfo->graduation==1){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('graduationexamlevel'),
                        'institute_name'=> $request->input('graduationinstitute_name'),
                        'group_subject'=> $request->input('graduationsubject'),
                        'result'=> $request->input('graduationresult'),
                        'cgpa'=> $request->input('graduationresult_score'),
                        'out_of'=> $request->input('graduationresult'),
                        'board_university'=> $request->input('graduationuniversity'),
                        'passing_year'=> $request->input('graduationpassyear'),
                    ]);

                }
                if($jobinfo->masters==1){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('mastersexamlevel'),
                        'institute_name'=> $request->input('mastersinstitute_name'),
                        'group_subject'=> $request->input('mastersSubject'),
                        'result'=> $request->input('mastersresult'),
                        'cgpa'=> $request->input('mastersresult_score'),
                        'out_of'=> $request->input('mastersresult'),
                        'board_university'=> $request->input('mastersuniversity'),
                        'passing_year'=> $request->input('masterspassyear'),
                    ]);

                }
                DB::commit();
                return redirect()->route('applicantPreview', ['uuid' => $applicant->uuid]);
            } catch (\Exception $e) {
                DB::rollback();
dd($e->getMessage());
            }
            dd($request->all());

        }
        else{
            return redirect()->back()
                ->with('error', 'Something went wrong. Try again');
        }


//        $request->validate([
//            'name_en' => 'required|max:255',
//            'name_bn' => 'required|max:255',
//            'father_name' => 'required|max:255',
//            'mother_name' => 'required|max:255',
//            'date_of_birth' => 'required|max:255',
//            'mobile_no' => 'required|max:255',
//            'nationality' => 'required|max:255',
//            'religion' => 'required|max:255',
//            'gender' => 'required|max:255',
//            'date_of_place' => 'required|max:255',
//
//        ]);
    }
    public function applicantPreview(Request $request, $uuid){

       $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla'])->where('uuid', $uuid)->first();
        // dd($applicationinfo->educations);
        return view('jobs.applyformPreview',['applicationinfo'=>$applicationinfo]);


    }

    public function applicantPreviewEdit(Request $request, $uuid){
        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla'])->where('uuid', $uuid)->first();

        $job= Job::find($applicationinfo->job_id);
        $district_Upozilla = DB::table('district_upozilla')->orderBy('zilla_name','ASC')->get()->toArray();
        $district = DB::table('district_upozilla')->where('zilla_id',0)->orderBy('zilla_name','ASC')->pluck('zilla_name','id');

        $boards = DB::table('boards')->orderBy('name','ASC')->pluck('name','id');
        $examlist= Examlevel::select('id','name','status')->with(['examGroups'=>function($quert){
            $quert->with(['examSubject'=>function($query){
                $query->select('id','examlevel_id','examlevel_group_id','name');
            }])->select('id','examlevel_id','name','status');
        }])->get();
        return view('jobs.applyformPreviewEdit',[
            'applicationinfo'=>$applicationinfo,
            'job'=>$job,
            'district_Upozilla'=>$district_Upozilla,
            'boards'=>$boards,
            'district'=>$district,
            'examlist'=>$examlist,]);
    }
}
