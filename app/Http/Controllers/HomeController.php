<?php

namespace App\Http\Controllers;

use App\Helpers\StaticValue;
use App\Models\Applicant;
use App\Models\ApplicantCertificate;
use App\Models\ApplicantEducation;
use App\Models\Board;
use App\Models\Examlevel;
use App\Models\ExamlevelSubject;
use App\Models\Job;
use App\Models\JobApply;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
            $job= Job::with(['certificates'=>function($query){
                $query->with(['certificate'=>function($qq){
                    $qq->select('id','name')->pluck('name','id');
                }]);
            }])->active()->activeJobs()->where('uuid',$uuid)->firstOrFail();
        //    dd($job);
            $district_Upozilla = DB::table('district_upozilla')->orderBy('zilla_name','ASC')->get()->toArray();
            $district = collect($district_Upozilla)->where('zilla_id',0)->pluck('zilla_name','id');
            $Upozilla = collect($district_Upozilla)->where('zilla_id','>', 0)->pluck('upozilla','id');
            $boards = DB::table('boards')->orderBy('name','ASC')->get();

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
                 'district'=>$district,
                 'Upozilla'=>$Upozilla,
                ]);
        } catch (ModelNotFoundException $e) {

            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }

    public function examSubject(Request $request){
$jobID=$request->JobID;
      $subject=  ExamlevelSubject::whereHas('JobSubject', function ($query) use($jobID){
        $query->where('job_id', $jobID);
    })->with(['examGroup','examlevel'])

            ->where([
                ['examlevel_id', $request->exam],
                ['examlevel_group_id', $request->examgroup],
            ])->get();
          //  dd($subject);
        return response()->json(['success' => true, 'data' => $subject]);

    }

    public function jobApply(Request $request){

       // dd($request->all());
       $job= Job::where('uuid',$request->uuid )->first();
       //dd($job);
        if($job){
// |regex:/^[\p{Bengali}]{0,100}$/u
            $validator = Validator::make($request->all(), [
                'uuid' => 'required',
                'name_en' => 'required|max:255',
                'name_bn' => 'required|max:255',
                'father_name' => 'required|max:255',
                'mother_name' => 'required|max:255',
                'date_of_birth' => 'required|date_format:Y-m-d',
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
                'signature' => 'required|mimes:jpeg,png,jpg,gif|max:1024',

                'jscexamlevel' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscinstitute_name' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscresult' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscboard' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscpassyear' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],


                'sscexamlevel' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscinstitute_name' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscresult' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscSubject' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscboard' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscpassyear' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],


                'hscexamlevel' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscinstitute_name' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscresult' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscubject' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscboard' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscpassyear' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],


                'graduationexamlevel' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationinstitute_name' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationresult' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationsubject' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationuniversity' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationpassyear' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],


                'mastersexamlevel' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                })],

                'certificate' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],

                'certificateinstitute_name' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],

                'certificate_no' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],
                'certificate_expire' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],

            ],
            [
                'name_en.required' => 'প্রার্থীর নাম ইংরেজীতে (বড় অক্ষরে) লিখুন',
                'name_bn.required'  => 'প্রার্থীর নাম বাংলায় লিখুন',
                'name_bn.regex'  => 'প্রার্থীর নাম বাংলায় লিখুন',
                'father_name.required' => 'পিতার নাম লিখুন ',
                'mother_name.required' => 'মাতার নাম লিখুন',
                'date_of_birth.required' => 'জন্ম তারিখ লিখুন',
                'date_of_birth.date_format' => 'জন্ম তারিখের ফরমেট ঠিক নেই',
                'mobile_no.required' => 'মোবাইল/টেলিফোন নম্বর লিখুন',
                'nationality.required' => 'জাতীয়তা নির্বাচন করুন',
                'religion.required' => 'ধর্ম নির্বাচন করুন',
                'gender.required' => 'জেন্ডার নির্বাচন করুন',
                'date_of_place.required' => 'জন্ম স্থান (জেলা) নির্বাচন করুন',
                'present_postoffice.required' => 'বর্তমান ঠিকানার ডাকঘর লিখুন',
                'present_postcode.required' => 'বর্তমান ঠিকানার পোস্টকোড নম্বর লিখুন',
                'present_zilla.required' => 'বর্তমান ঠিকানার জেলা নির্বাচন করুন ',
                'present_upozilla.required' => 'বর্তমান ঠিকানার উপজেলা/থানা নির্বাচন করুন ',
                'permanent_postoffice.required' => 'স্থায়ী ঠিকানার ডাকঘর লিখুন',
                'permanent_postcode.required' => 'স্থায়ী ঠিকানার পোস্টকোড নম্বর লিখুন',
                'permanent_zilla.required' => 'স্থায়ী ঠিকানার জেলা নির্বাচন করুন',
                'permanent_upozilla.required' => 'স্থায়ী ঠিকানার উপজেলা/থানা নির্বাচন করুন',
                'image.required' => 'প্রার্থীর ছবি নির্বাচন করুন',
                'signature.required' => 'প্রার্থীর স্বাক্ষর নির্বাচন করুন',
                'jscexamlevel.required' => 'জে.এস.সি/ সমমান পরীক্ষার নাম নির্বাচন করুন',
                'jscinstitute_name.required' => 'শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'jscresult.required' => 'গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'jscboard.required' => 'বোর্ড নির্বাচন করুন',
                'jscpassyear.required' => 'পাসের সন লিখুন',

                'sscexamlevel.required' => 'এস.এস.সি/ সমমান পরীক্ষার নাম নির্বাচন করুন',
                'sscinstitute_name.required' => 'এস.এস.সি/ সমমান শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'sscresult.required' => 'এস.এস.সি/ সমমান গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'sscSubject.required' => 'এস.এস.সি/ সমমান বিষয় নির্বাচন করুন',
                'sscboard.required' => 'এস.এস.সি/ সমমান বোর্ড নির্বাচন করুন ',
                'sscpassyear.required' => 'এস.এস.সি/ সমমান পাসের সন লিখুন',

                'hscexamlevel.required' => 'এইচএসসি /সমমূল্য পরীক্ষার নাম নির্বাচন করুন',
                'hscinstitute_name.required' => 'এইচএসসি /সমমূল্য শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'hscresult.required' => 'এইচএসসি /সমমূল্য গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'hscubject.required' => 'এইচএসসি /সমমূল্য বিষয় নির্বাচন করুন',
                'hscboard.required' => 'এইচএসসি /সমমূল্য বোর্ড নির্বাচন করুন ',
                'hscpassyear.required' => 'এইচএসসি /সমমূল্য পাসের সন লিখুন',

                'graduationexamlevel.required' => 'স্নাতক ডিগ্রী পরীক্ষার নাম নির্বাচন করুন',
                'graduationinstitute_name.required' => 'স্নাতক ডিগ্রী শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'graduationresult.required' => 'স্নাতক ডিগ্রী গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'graduationsubject.required' => 'স্নাতক ডিগ্রী বিষয় নির্বাচন করুন',
                'graduationuniversity.required' => 'স্নাতক ডিগ্রী বিশ্ববিদ্যালয়/ইনস্টিটিউট নির্বাচন করুন ',
                'graduationpassyear.required' => 'স্নাতক ডিগ্রী পাসের সন লিখুন',

                'mastersexamlevel.required' => 'স্নাতকোত্তর পরীক্ষার নাম নির্বাচন করুন',
                'mastersinstitute_name.required' => 'স্নাতকোত্তর শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'mastersresult.required' => 'স্নাতকোত্তর গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'mastersSubject.required' => 'স্নাতকোত্তর বিষয় নির্বাচন করুন',
                'mastersuniversity.required' => 'স্নাতকোত্তর বিশ্ববিদ্যালয়/ইনস্টিটিউট নির্বাচন করুন ',
                'masterspassyear.required' => 'স্নাতকোত্তর পাসের সন লিখুন',

                 'certificate.required' => 'সার্টিফিকেশন নাম নির্বাচন করুন',
                 'certificateinstitute_name.required' => 'সার্টিফিকেশন প্রতিষ্ঠান নাম লিখুন',
                 'certificate_no.required' => 'সার্টিফিকেশন গ্রেড/শ্রেণি/বিভাগ লিখুন',
                'certificate_expire.required' => 'সার্টিফিকেশন গ্রেড/শ্রেণি/বিভাগ লিখুন',



              ]
            );
            $flag=false;
        if($request->input('repetition')){

        }
        else{
            $validator->sometimes('date_of_birth_cal', 'required', function () use ($request){
                $result= $this->applyAgeCalculationComon($request);

                return ($result==='No');

          });
        }




            if($job->min_education_con=="AND"){
                $validator->sometimes(['jscexamlevel', 'jscinstitute_name','jscresult','jscboard','jscpassyear'], 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });


                $validator->sometimes(['sscexamlevel','sscinstitute_name','sscresult','sscSubject','sscboard','sscpassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });


                $validator->sometimes(['hscexamlevel','hscinstitute_name','hscresult','hscubject','hscboard','hscpassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });


                $validator->sometimes(['graduationexamlevel','graduationinstitute_name','graduationresult','graduationsubject','graduationuniversity','graduationpassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });


                $validator->sometimes(['mastersexamlevel','mastersinstitute_name','mastersresult','mastersSubject','mastersuniversity','masterspassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });

                $validator->sometimes(['hscexamlevel','hscinstitute_name','hscresult','hscubject','hscboard','hscpassyear'], 'required', function () use ($job){
                    return (( $job->min_education_with=='HSC') AND  $job->hsc==1);
                });

                $validator->sometimes(['graduationexamlevel','graduationinstitute_name','graduationresult','graduationsubject','graduationuniversity','graduationpassyear'], 'required', function () use ($job){
                    return (( $job->min_education_with=='Graduation') AND  $job->graduation==1);
                });

                $validator->sometimes(['graduationexamlevel','graduationinstitute_name','graduationresult','graduationsubject','graduationuniversity','graduationpassyear'], 'required', function () use ($job){

                    return (( $job->min_education_with=='Masters') AND  $job->graduation==1);
                });


            }



/*
$validator->after(function ($validator) {
    if ($validator->errors()->isNotEmpty()) {
        $validator->errors()->add('date_of_birth', 'বয়স এর কারণে আপনি এই পদে আবেদন করতে পারবেন না!');

    }
});
*/

            if ($validator->fails()) {
               // dd($validator);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

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


            date_default_timezone_set('Asia/Dhaka');
            $bday=$request->input('date_of_birth');
            $fixedday=$request->input('age_calculation');

            $datetime1 = new \DateTime($fixedday);
            $datetime2 = new \DateTime($bday);
             $interval = $datetime1->diff($datetime2);
            $year= $interval->format('%y');
            $month= $interval->format('%m');
            $day= $interval->format('%d');
            $age=$year.'.'.$month;

            DB::beginTransaction();

            try {

                $applicant= Applicant::create([
                    'job_id' => $jobinfo->id,
                    'uuid' => (string) Str::uuid(),
                    'name_bn' => $request->input('name_bn'),
                    'name_en' => $request->input('name_en'),
                    'nid' => $request->input('nidorbrn')=="NID" ?  $request->input('nidorbrnnumber') :'',
                    'brn' => $request->input('nidorbrn')=="BRN" ?  $request->input('nidorbrnnumber') :'',
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
                    'quota' => $request->input('quota') ? json_encode($request->input('quota')):NULL,
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
                    'age' => $age,
                    'code' => '',
                    'eligible' => 0,
                    'repetition' => $request->input('repetition'),
                    'jobcurday' => $request->input('jobcurday'),
                ]);
                $education=[];

                if($request->input('jscexamlevel')){
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

                if($request->input('sscexamlevel')){
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
                        'other'=> $request->input('sscSubject_other'),
                    ]);

                }

                if($request->input('hscexamlevel')){
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
                        'other'=> $request->input('hscubject_other'),
                    ]);

                }
                if($request->input('graduationexamlevel')){
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
                        'other'=> $request->input('graduationsubject_other'),
                    ]);

                }
                if($request->input('mastersexamlevel')){
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
                        'other'=> $request->input('mastersSubject_other'),
                    ]);

                }
                if($jobinfo->certificate=="YES"){
                    ApplicantCertificate::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('certificate'),
                        'institute_name'=> $request->input('certificateinstitute_name'),
                        'certificate_no'=> $request->input('certificate_no'),
                        'certificate_expire'=> $request->input('certificate_expire'),
                    ]);

                }

                DB::commit();
                return redirect()->route('applicantPreview', ['uuid' => $applicant->uuid]);
            } catch (\Exception $e) {
                DB::rollback();
//dd($e->getMessage());
Log::info($e->getMessage());
            }


        }
        else{
            return redirect()->back()
                ->with('error', 'Something went wrong. Try again');
        }


    }

    public function applicantPreview(Request $request, $uuid)
    {

        try {

            $applicationinfo = Applicant::with(['educations', 'job', 'birthplace', 'zila', 'upozilla', 'permanentzila', 'permanentupozilla','applicantCertificate'])->where('uuid', $uuid)->first();
            //dd($applicationinfo);
            if ($applicationinfo->eligible == 0) {
                return view('jobs.applyformPreview', ['applicationinfo' => $applicationinfo]);
            } else {
                return redirect()->route('home')
                    ->with('error', 'No data found!!!');;
            }

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Something wrong!!');;
        }


    }

    public function applicantPreviewEdit(Request $request, $uuid){
        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','applicantCertificate'])->where('uuid', $uuid)->first();

        $job= Job::find($applicationinfo->job_id);
        $district_Upozilla = DB::table('district_upozilla')->orderBy('zilla_name','ASC')->get()->toArray();
        $district = DB::table('district_upozilla')->where('zilla_id',0)->orderBy('zilla_name','ASC')->pluck('zilla_name','id');

        $boards = DB::table('boards')->orderBy('name','ASC')->get();
        // pluck('name','id')
        //dd(collect($boards)->where('type',1)->pluck('name','id'));
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

    public function applicantPreviewConfirm(Request $request, $uuid){
        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla'])->where('uuid', $uuid)->first();
        $job= Job::find($applicationinfo->job_id);
        if($applicationinfo && $job){
            $validator = Validator::make($request->all(), [
                'name_en' => 'required|max:255',
               'name_bn' => 'required|max:255',
                'father_name' => 'required|max:255',
                'mother_name' => 'required|max:255',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'date_of_birth' => 'sometimes|required',
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
                'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024',
                'signature' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024',

                // 'jscexamlevel' => 'sometimes|required|max:255',
                // 'jscinstitute_name' => 'sometimes|required|max:255',
                // 'jscresult' => 'sometimes|required|max:255',
                // 'jscboard' => 'sometimes|required|max:255',
                // 'jscpassyear' => 'sometimes|required|max:255',
                // 'sscexamlevel' => 'sometimes|required|max:255',
                // 'sscinstitute_name' => 'sometimes|required|max:255',
                // 'sscresult' => 'sometimes|required|max:255',
                // 'sscSubject' => 'sometimes|required|max:255',
                // 'sscboard' => 'sometimes|required|max:255',
                // 'sscpassyear' => 'sometimes|required|max:255',

                // 'hscexamlevel' => 'sometimes|required|max:255',
                // 'hscinstitute_name' => 'sometimes|required|max:255',
                // 'hscresult' => 'sometimes|required|max:255',
                // 'hscubject' => 'sometimes|required|max:255',
                // 'hscboard' => 'sometimes|required|max:255',
                // 'hscpassyear' => 'sometimes|required|max:255',

                // 'graduationexamlevel' => 'sometimes|required|max:255',
                // 'graduationinstitute_name' => 'sometimes|required|max:255',
                // 'graduationresult' => 'sometimes|required|max:255',
                // 'graduationsubject' => 'sometimes|required|max:255',
                // 'graduationuniversity' => 'sometimes|required|max:255',
                // 'graduationpassyear' => 'sometimes|required|max:255',

                // 'mastersexamlevel' => 'sometimes|required|max:255',
                // 'mastersinstitute_name' => 'sometimes|required|max:255',
                // 'mastersresult' => 'sometimes|required|max:255',
                // 'mastersSubject' => 'sometimes|required|max:255',
                // 'mastersuniversity' => 'sometimes|required|max:255',
                // 'certificate' => 'sometimes|required|max:255',
                // 'certificateinstitute_name' => 'sometimes|required|max:255',
                // 'certificateduration' => 'sometimes|required|max:255',


                'jscexamlevel' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscinstitute_name' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscresult' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscboard' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],
                'jscpassyear' => [Rule::requiredIf(function () use($job) {
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                })],


                'sscexamlevel' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscinstitute_name' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscresult' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscSubject' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscboard' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],
                'sscpassyear' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                })],


                'hscexamlevel' => [Rule::requiredIf(function () use($job) {
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscinstitute_name' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscresult' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscubject' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscboard' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],
                'hscpassyear' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                })],


                'graduationexamlevel' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationinstitute_name' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationresult' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationsubject' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationuniversity' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],
                'graduationpassyear' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                })],


                'mastersexamlevel' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                })],

                'mastersinstitute_name' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                })],

                'mastersresult' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                })],

                'mastersSubject' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                })],

                'mastersuniversity' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                })],

                'masterspassyear' => [Rule::requiredIf(function () use($job) {

                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                })],

                'certificate' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],

                'certificateinstitute_name' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],

                'certificate_no' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],
                'certificate_expire' => [Rule::requiredIf(function () use($job) {
                    return $job->certificate_isrequired==1;
                })],


            ],
            [
                'name_en.required' => 'প্রার্থীর নাম ইংরেজীতে (বড় অক্ষরে) লিখুন',
                'name_bn.required'  => 'প্রার্থীর নাম বাংলায় লিখুন',
                'name_bn.regex'  => 'প্রার্থীর নাম বাংলায় লিখুন',
                'father_name.required' => 'পিতার নাম লিখুন ',
                'mother_name.required' => 'মাতার নাম লিখুন',
                'date_of_birth.required' => 'জন্ম তারিখ লিখুন',
                'date_of_birth.date_format' => 'জন্ম তারিখের ফরমেট ঠিক নেই',
                'mobile_no.required' => 'মোবাইল/টেলিফোন নম্বর লিখুন',
                'nationality.required' => 'জাতীয়তা নির্বাচন করুন',
                'religion.required' => 'ধর্ম নির্বাচন করুন',
                'gender.required' => 'জেন্ডার নির্বাচন করুন',
                'date_of_place.required' => 'জন্ম স্থান (জেলা) নির্বাচন করুন',
                'present_postoffice.required' => 'বর্তমান ঠিকানার ডাকঘর লিখুন',
                'present_postcode.required' => 'বর্তমান ঠিকানার পোস্টকোড নম্বর লিখুন',
                'present_zilla.required' => 'বর্তমান ঠিকানার জেলা নির্বাচন করুন ',
                'present_upozilla.required' => 'বর্তমান ঠিকানার উপজেলা/থানা নির্বাচন করুন ',
                'permanent_postoffice.required' => 'স্থায়ী ঠিকানার ডাকঘর লিখুন',
                'permanent_postcode.required' => 'স্থায়ী ঠিকানার পোস্টকোড নম্বর লিখুন',
                'permanent_zilla.required' => 'স্থায়ী ঠিকানার জেলা নির্বাচন করুন',
                'permanent_upozilla.required' => 'স্থায়ী ঠিকানার উপজেলা/থানা নির্বাচন করুন',
                'image.required' => 'প্রার্থীর ছবি নির্বাচন করুন',
                'signature.required' => 'প্রার্থীর স্বাক্ষর নির্বাচন করুন',
                'jscexamlevel.required' => 'জে.এস.সি/ সমমান পরীক্ষার নাম নির্বাচন করুন',
                'jscinstitute_name.required' => 'শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'jscresult.required' => 'গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'jscboard.required' => 'বোর্ড নির্বাচন করুন',
                'jscpassyear.required' => 'পাসের সন লিখুন',

                'sscexamlevel.required' => 'এস.এস.সি/ সমমান পরীক্ষার নাম নির্বাচন করুন',
                'sscinstitute_name.required' => 'এস.এস.সি/ সমমান শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'sscresult.required' => 'এস.এস.সি/ সমমান গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'sscSubject.required' => 'এস.এস.সি/ সমমান বিষয় নির্বাচন করুন',
                'sscboard.required' => 'এস.এস.সি/ সমমান বোর্ড নির্বাচন করুন ',
                'sscpassyear.required' => 'এস.এস.সি/ সমমান পাসের সন লিখুন',

                'hscexamlevel.required' => 'এইচএসসি /সমমূল্য পরীক্ষার নাম নির্বাচন করুন',
                'hscinstitute_name.required' => 'এইচএসসি /সমমূল্য শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'hscresult.required' => 'এইচএসসি /সমমূল্য গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'hscubject.required' => 'এইচএসসি /সমমূল্য বিষয় নির্বাচন করুন',
                'hscboard.required' => 'এইচএসসি /সমমূল্য বোর্ড নির্বাচন করুন ',
                'hscpassyear.required' => 'এইচএসসি /সমমূল্য পাসের সন লিখুন',

                'graduationexamlevel.required' => 'স্নাতক ডিগ্রী পরীক্ষার নাম নির্বাচন করুন',
                'graduationinstitute_name.required' => 'স্নাতক ডিগ্রী শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'graduationresult.required' => 'স্নাতক ডিগ্রী গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'graduationsubject.required' => 'স্নাতক ডিগ্রী বিষয় নির্বাচন করুন',
                'graduationuniversity.required' => 'স্নাতক ডিগ্রী বিশ্ববিদ্যালয়/ইনস্টিটিউট নির্বাচন করুন ',
                'graduationpassyear.required' => 'স্নাতক ডিগ্রী পাসের সন লিখুন',

                'mastersexamlevel.required' => 'স্নাতকোত্তর পরীক্ষার নাম নির্বাচন করুন',
                'mastersinstitute_name.required' => 'স্নাতকোত্তর শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                'mastersresult.required' => 'স্নাতকোত্তর গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                'mastersSubject.required' => 'স্নাতকোত্তর বিষয় নির্বাচন করুন',
                'mastersuniversity.required' => 'স্নাতকোত্তর বিশ্ববিদ্যালয়/ইনস্টিটিউট নির্বাচন করুন ',
                'masterspassyear.required' => 'স্নাতকোত্তর পাসের সন লিখুন',

                 'certificate.required' => 'সার্টিফিকেশন নাম নির্বাচন করুন',
                 'certificateinstitute_name.required' => 'সার্টিফিকেশন প্রতিষ্ঠান নাম লিখুন',
                 'certificateduration.required' => 'সার্টিফিকেশন গ্রেড/শ্রেণি/বিভাগ লিখুন',

                 'date_of_birth.sometimes' => 'বয়স এর কারণে আপনি এই পদে আবেদন করতে পারবেন না!',

              ]
            );

            $validator->sometimes(['jscexamlevel', 'jscinstitute_name','jscresult','jscboard','jscpassyear'], 'required', function () use ($job){
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });

            $validator->sometimes(['sscexamlevel','sscinstitute_name','sscresult','sscSubject','sscboard','sscpassyear'], 'required', function () use ($job){
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });

            $validator->sometimes(['hscexamlevel','hscinstitute_name','hscresult','hscubject','hscboard','hscpassyear'], 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes(['graduationexamlevel','graduationinstitute_name','graduationresult','graduationsubject','graduationuniversity','graduationpassyear'], 'required', function () use ($job){
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });


            $validator->sometimes(['mastersexamlevel','mastersinstitute_name','mastersresult','mastersSubject','mastersuniversity','masterspassyear'], 'required', function () use ($job){
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });

            if($request->input('repetition')==1){

            }
            else{
                $validator->sometimes('date_of_birth', 'required', function () use ($request){
                    $result= $this->applyAgeCalculationComon($request);
                    return ($result==='No');

              });
            }




           if($job->min_education_con=="AND"){
                $validator->sometimes(['jscexamlevel', 'jscinstitute_name','jscresult','jscboard','jscpassyear'], 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });


                $validator->sometimes(['sscexamlevel','sscinstitute_name','sscresult','sscSubject','sscboard','sscpassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });


                $validator->sometimes(['hscexamlevel','hscinstitute_name','hscresult','hscubject','hscboard','hscpassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });


                $validator->sometimes(['graduationexamlevel','graduationinstitute_name','graduationresult','graduationsubject','graduationuniversity','graduationpassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });


                $validator->sometimes(['mastersexamlevel','mastersinstitute_name','mastersresult','mastersSubject','mastersuniversity','masterspassyear'], 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });

                $validator->sometimes(['hscexamlevel','hscinstitute_name','hscresult','hscubject','hscboard','hscpassyear'], 'required', function () use ($job){
                    return (( $job->min_education_with=='HSC') AND  $job->hsc==1);
                });

                $validator->sometimes(['graduationexamlevel','graduationinstitute_name','graduationresult','graduationsubject','graduationuniversity','graduationpassyear'], 'required', function () use ($job){
                    return (( $job->min_education_with=='Graduation') AND  $job->graduation==1);
                });

                $validator->sometimes(['graduationexamlevel','graduationinstitute_name','graduationresult','graduationsubject','graduationuniversity','graduationpassyear'], 'required', function () use ($job){

                    return (( $job->min_education_with=='Masters') AND  $job->graduation==1);
                });


            }

        $validator->sometimes(['certificate','certificateinstitute_name','certificate_no','certificate_expire'], 'required', function () use ($job){
            return $job->certificate_isrequired==1;
        });



            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            StaticValue::createDirecrotory($job->job_id);
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $nameimage = time() . '-' . mt_rand() . "." . $extension;
                $image->move(public_path('assets/applicants/' . date("Y") . '/' . $job->job_id), $nameimage);
                $nameimage = date("Y") . '/' . $job->job_id . '/' . $nameimage;
            }
            if($request->hasFile('signature')) {
                $signature = $request->file('signature');
                $extensionsignature = $signature->getClientOriginalExtension();
                $namesignature = time() . '-' . mt_rand() . "_signature." . $extensionsignature;
                $signature->move(public_path('assets/applicants/' . date("Y") . '/' . $job->job_id), $namesignature);
                $namesignature = date("Y") . '/' . $job->job_id . '/' . $namesignature;
            }

            date_default_timezone_set('Asia/Dhaka');
            $bday=$request->input('date_of_birth');
            $fixedday=$job->age_calculation;

            $datetime1 = new \DateTime($fixedday);
            $datetime2 = new \DateTime($bday);
             $interval = $datetime1->diff($datetime2);
            $year= $interval->format('%y');
            $month= $interval->format('%m');
            $day= $interval->format('%d');
            $age=$year.'.'.$month;

            DB::beginTransaction();

            try {
                $code=round(microtime(true) * 1000)+$applicationinfo->id;
                $applicant = Applicant::where('id', $applicationinfo->id)
                    ->update([
                        'name_bn' => $request->input('name_bn'),
                        'name_en' => $request->input('name_en'),
                        'nid' => $request->input('nidorbrn')=="NID" ?  $request->input('nidorbrnnumber') :'',
                        'brn' => $request->input('nidorbrn')=="BRN" ?  $request->input('nidorbrnnumber') :'',
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
                        'division_appli' => $request->input('divisioncaplicant'),
                        'quota' => $request->input('quota') ? json_encode($request->input('quota')):NULL,
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
                        'picture' => $request->hasFile('image') ? $nameimage : $applicationinfo->picture,
                        'signature' => $request->hasFile('signature') ? $namesignature : $applicationinfo->signature,
                        'job_circular' => '',
                        'experienceyear' => $request->input('experienceyear'),
                        'experiencemonth' => $request->input('experiencemonth'),
                        'age' => $age,
                        'code' => $code,
                        'eligible' => 0,
                        'repetition' => $request->input('repetition'),
                        'jobcurday' => $request->input('jobcurday'),
                    ]);

                @ApplicantEducation::where(['applicants_id'=> $applicationinfo->id,'job_id'=> $job->id])->delete();

                if($request->input('jscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
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

                if($request->input('sscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('sscexamlevel'),
                        'institute_name'=> $request->input('sscinstitute_name'),
                        'group_subject'=> $request->input('sscSubject'),
                        'result'=> $request->input('sscresult'),
                        'cgpa'=> $request->input('sscresult_score'),
                        'out_of'=> $request->input('sscresult'),
                        'board_university'=> $request->input('sscboard'),
                        'passing_year'=> $request->input('sscpassyear'),
                        'other'=> $request->input('sscSubject_other'),
                    ]);

                }

                if($request->input('hscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('hscexamlevel'),
                        'institute_name'=> $request->input('hscinstitute_name'),
                        'group_subject'=> $request->input('hscubject'),
                        'result'=> $request->input('hscresult'),
                        'cgpa'=> $request->input('hscresult_score'),
                        'out_of'=> $request->input('hscresult'),
                        'board_university'=> $request->input('hscboard'),
                        'passing_year'=> $request->input('hscpassyear'),
                        'other'=> $request->input('hscubject_other'),
                    ]);

                }
                if($request->input('graduationexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('graduationexamlevel'),
                        'institute_name'=> $request->input('graduationinstitute_name'),
                        'group_subject'=> $request->input('graduationsubject'),
                        'result'=> $request->input('graduationresult'),
                        'cgpa'=> $request->input('graduationresult_score'),
                        'out_of'=> $request->input('graduationresult'),
                        'board_university'=> $request->input('graduationuniversity'),
                        'passing_year'=> $request->input('graduationpassyear'),
                        'other'=> $request->input('graduationsubject_other'),
                    ]);

                }
                if($request->input('mastersexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('mastersexamlevel'),
                        'institute_name'=> $request->input('mastersinstitute_name'),
                        'group_subject'=> $request->input('mastersSubject'),
                        'result'=> $request->input('mastersresult'),
                        'cgpa'=> $request->input('mastersresult_score'),
                        'out_of'=> $request->input('mastersresult'),
                        'board_university'=> $request->input('mastersuniversity'),
                        'passing_year'=> $request->input('masterspassyear'),
                        'other'=> $request->input('mastersSubject_other'),
                    ]);

                }
                if($job->certificate=="YES"){
                   @ApplicantCertificate::where(['applicants_id'=> $applicationinfo->id,'job_id'=> $job->id])->delete();

                    ApplicantCertificate::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('certificate'),
                        'institute_name'=> $request->input('certificateinstitute_name'),
                        'certificate_no'=> $request->input('certificate_no'),
                        'certificate_expire'=> $request->input('certificate_expire'),
                    ]);

                }

              /*
                JobApply::create([
                    'applicants_id'=> $applicationinfo->id,
                    'job_id'=> $job->id,
                    'received'=> 2,
                    'token'=> $code,
                    'bd_tk'=> $job->apply_fee,
                    'apply_date'=> date('Y-m-d H:i:s'),
                ]);
*/
                DB::commit();
             //   dd($applicationinfo->uuid);
                return redirect()->route('applicantPreview', ['uuid' => $applicationinfo->uuid]);
             //   return redirect()->route('applicantPreview', ['uuid' => $applicationinfo->uuid]);
               // return redirect()->route('applicationPrint', ['uuid' => $applicationinfo->uuid]);
            }
            catch (\Exception $e) {
                DB::rollback();
                Log::info($e->getMessage());
              //  dd($e->getMessage());
             //   Log::info($e->getMessage());
                return redirect()->route('home')
                    ->with('error', 'something wrong!!!');;
            }


        }


    }

    public function applicantConfirm(Request $request, $uuid){

        try {
            DB::beginTransaction();
            $applicationinfo= Applicant::where('uuid', $uuid)->first();
            $job= Job::find($applicationinfo->job_id);
            $code=round(microtime(true) * 1000)+$applicationinfo->id;
            $applicationinfo->eligible=1;
            $applicationinfo->save();
            JobApply::create([
                'applicants_id'=> $applicationinfo->id,
                'job_id'=> $job->id,
                'received'=> 2,
                'token'=> $code,
                'bd_tk'=> $job->apply_fee,
                'apply_date'=> date('Y-m-d H:i:s'),
            ]);
            // TODO
            // update code in application table
            Applicant::where('id',$applicationinfo->id)->where('eligible', 1)->update(['code'=>$code]);
            DB::commit();
            return redirect()->route('applicationPrint', ['uuid' => $applicationinfo->uuid]);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
           // return $e->getMessage();
            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }

    public function applicationPrint(Request $request, $uuid){

        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','apliyedJob','applicantCertificate'])->where('uuid', $uuid)->first();
      // dd($applicationinfo);
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

    public function university(){

        foreach (\App\Helpers\StaticValue::UNIVERSITIES as $UNIVERSITY){
            Board::updateOrCreate(['name'=>$UNIVERSITY, 'type'=>2]);

        }
    }

    public function PrintCopy(Request $request){

        if ($request->has('applied_code')) {
            $applicant= Applicant::whereHas('apliyedJob')->with('apliyedJob')->where([
                'code'=> $request->input('applied_code')
            ])->first();

//            $applicant= JobApply::with('applicant')->where([
//                'token'=> $request->input('applied_code')
//            ])->first();
            return view('jobs.printCopy',[
                'applicationinfo'=>$applicant,
            ]);
        }




        return view('jobs.printCopy',[
            'applicationinfo'=>[],
        ]);
    }
    public function writtenCopy(Request $request){

        if ($request->has('applied_code')) {
            $applicant= Applicant::whereHas('apliyedJob')->with('apliyedJob')->where([
                'code'=> $request->input('applied_code'),
                'eligible'=> 2,
            ])->first();

            return view('jobs.writtenCard',[
                'applicationinfo'=>$applicant,
            ]);
        }
        return view('jobs.writtenCard',[
            'applicationinfo'=>[],
        ]);
    }
    public function writtenadminCard(Request $request, $uuid){
       try {
           $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','apliyedJob','applicantCertificate'])->where('uuid', $uuid)->first();

           if ($applicationinfo->eligible == 2) {
               return view('layouts.print', [
                   'appliedddata' => $applicationinfo,
               ]);
           } else {
               return redirect()->route('home')
                   ->with('error', 'No data found!!!');;
           }
       } catch (\Exception $e) {

            return $e->getMessage();
        }


    }
    public function vivaCopy(Request $request){
        if ($request->has('applied_code')) {
            $applicant= Applicant::whereHas('apliyedJob')->with('apliyedJob','viva')->where([
                'code'=> $request->input('applied_code'),
                'eligible'=> 2,
            ])->whereHas('viva')->first();

            return view('jobs.vivaCard',[
                'applicationinfo'=>$applicant,
            ]);
        }

        return view('jobs.vivaCard',[
            'applicationinfo'=>[],
        ]);
    }

    public function vivaadminCard(Request $request, $uuid){

        try {
            $applicationinfo= Applicant::whereHas('apliyedJob')->with('apliyedJob','viva')->where([
                'uuid'=> $uuid,
                'eligible'=> 2,
            ])->whereHas('viva')->first();
            if ($applicationinfo->eligible == 2) {
                return view('layouts.viva_admit', [
                    'appliedddata' => $applicationinfo,
                ]);
            } else {
                return redirect()->route('home')
                    ->with('error', 'No data found!!!');;
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }
    public function practicalCopy(Request $request){
        return view('jobs.practicalCopy',[
            'applicationinfo'=>[],
        ]);
    }
    public function medicalCopy(Request $request){
        return view('jobs.medicalCopy',[
            'applicationinfo'=>[],
        ]);
    }

    public function ageCalculation(Request $request){


        date_default_timezone_set('Asia/Dhaka');
        $bday=$request->input('bday');
        $fixedday=$request->input('fixedday');
        $datetime1 = new \DateTime($fixedday);
        $datetime2 = new \DateTime($bday);
        $interval = $datetime1->diff($datetime2);
        return response()->json(['success' => true, 'data' =>  '<strong>'.$fixedday.' তারিখে প্রার্থীর বয়স :'.$interval->format('%y years %m months and %d days').'<strong>']);



    }

    public function applyAgeCalculation(Request $request)
    {
        //  dd($request->input('repetition'));
        //  dd($request->all());
        //  dd($request->input('repetition'));


        date_default_timezone_set('Asia/Dhaka');
        $bday = $request->input('bday');
        $fixedday = $request->input('fixedday');

        $job = Job::find($request->input('RndID'));
        $max_age = $job->max_age;
        $min_age = $job->min_age;
        $freedom_fighter = $job->freedom_fighter;
        $handicapped_age = $job->handicapped_age;
        $petition_age = $job->petition_age;
        $divisioncaplicant_age = $job->divisioncaplicant_age;
        // dd(max(array($max_age,$freedom_fighter,$handicapped_age,$petition_age)));


//dd($agearray);
//dd(max($agearray));
        $freedom = $request->input('quota');
        $divisioncaplicant = $request->input('divisioncaplicant');
        // dd($bday, $fixedday, $freedom, $divisioncaplicant);
        $datetime1 = new \DateTime($fixedday);
        $datetime2 = new \DateTime($bday);
        $interval = $datetime1->diff($datetime2);
        $year = $interval->format('%y');
        $month = $interval->format('%m');
        $day = $interval->format('%d');

        $total = $total = ($year * 365) + $day + ($month * 30);
        $minimumage = $request->input('minimumage') * 365;
        $mamximumage = $request->input('mamximumage') * 365;

        if (is_float($request->input('minimumage'))) {
            list($whole, $decimal) = explode('.', $request->input('minimumage'));
            $minimumage = ($whole * 365) + ($decimal * 30);
        } else {
            $minimumage = $request->input('minimumage') * 365;
        }

        if (is_float($request->input('mamximumage'))) {
            list($whole, $decimal) = explode('.', $request->input('mamximumage'));
            $minimumage = ($whole * 365) + ($decimal * 30);
        } else {
            $mamximumage = $request->input('mamximumage') * 365;
        }

        if ($request->input('repetition') == 'true' && (float)$total >= (float)$minimumage) {
            echo 'Yes';
            return;
        }


        $maxage = 0.0;
        $agearray = [];
        if ($request->has('quota')) {
            foreach ($request->input('quota') as $quota) {
                //echo $quota;
                if ($quota == "মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যা") {
                    $agearray[] = $job->freedom_fighter;

                }
                if ($quota == "মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যার পুত্র -কন্যা") {

                    $agearray[] = $job->freedom_fighter;
                }
                if ($quota == "ক্ষুদ্র নৃ -গোষ্ঠী") {
                    $agearray[] = $job->freedom_fighter;

                }

                if ($quota == "শারীরিক প্রতিবন্দী") {

                    $agearray[] = $job->handicapped_age;
                }
                if ($quota == "এতিম") {

                    $agearray[] = $job->handicapped_age;
                }

                $maxage = sprintf("%.1f", max($agearray));

            }


            if ($maxage > 0) {

                list($whole, $decimal) = explode('.', $maxage);
                $maxage = ($whole * 365) + ($decimal * 30);
            }


            if ((float)$total <= (float)$maxage && (float)$total >= (float)$minimumage) {

                return 'Yes';


            }

            if ((float)$total >= (float)$maxage && (float)$total >= (float)$minimumage) {

                return 'No';


            }


        }


//dd($total,$maxage );


        if ($divisioncaplicant == 'হ্যাঁ' && (float)$total >= (float)$minimumage) {

            $divisionalAge = $request->input('divisional') * 365;
            if ((float)$total <= (float)$divisionalAge) {
                echo 'Yes';
            } else {
                echo 'No';
            }

            return;
        }


        if ($total <= (float)$minimumage) {

            return 'No';
        }
        if ((float)$total >= (float)$mamximumage) {
            return 'No';
        }

        if ((float)$total >= (float)$minimumage && (float)$total <= (float)$mamximumage) {
            return 'Yes';
        } else {
            return 'No';
        }

//dd($minimumage, $total);
// else{
//     return 'No';
// }


    }


    public function applyAgeCalculationComon(Request $request){

        date_default_timezone_set('Asia/Dhaka');
        $bday=$request->input('date_of_birth');
        $fixedday=$request->input('age_calculation');
        $freedom=$request->input('quota');
        $divisioncaplicant=$request->input('divisioncaplicant_age');
       // dd($bday, $fixedday, $freedom, $divisioncaplicant);
        $datetime1 = new \DateTime($fixedday);
        $datetime2 = new \DateTime($bday);
         $interval = $datetime1->diff($datetime2);
        $year= $interval->format('%y');
        $month= $interval->format('%m');
        $day= $interval->format('%d');

        $total=$total=($year*365)+$day+($month*30);

        if(is_float($request->input('min_age'))){
            list($whole, $decimal) = explode('.', $request->input('min_age'));
            $minimumage=($whole*365)+($decimal*30);
            }
            else{
                $minimumage=$request->input('min_age')*365;
            }

            if(is_float($request->input('max_age'))){
                list($whole, $decimal) = explode('.', $request->input('max_age'));
                $minimumage=($whole*365)+($decimal*30);
                }
                else{
                    $mamximumage=$request->input('max_age')*365;
                }



                if($request->input('repetition')=='true' && (float)$total >=(float)$minimumage){
                    return 'Yes';
                }

        if($divisioncaplicant=='হ্যাঁ'){
            if(is_float($request->input('divisioncaplicant_age'))){
                list($whole, $decimal) = explode('.', $request->input('divisioncaplicant_age'));
                $minimumage=($whole*365)+($decimal*30);
                }
                else{
                    $divisionalAge=$request->input('divisioncaplicant_age')*365;
                }

        //echo $total.'='.divisionalAge;
                if((float)$total <= (float)$divisionalAge && $minimumage >= (float)$total){
                return 'Yes';
                }
                else{
                    return 'No';
                }

            return;
        }

        $job= Job::find($request->input('RndID'));
        $max_age=$job->max_age;
        $min_age=$job->min_age;
        $freedom_fighter=$job->freedom_fighter;
        $handicapped_age=$job->handicapped_age;
        $petition_age=$job->petition_age;
        $divisioncaplicant_age=$job->divisioncaplicant_age;

        $maxage=0.0;
        $agearray=[];
        if($request->has('quota')){
            foreach($request->input('quota') as $quota){
                //echo $quota;
                                    if($quota=="মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যা"){
                                        $agearray[]=$job->freedom_fighter;

                                    }
                                    if($quota=="মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যার পুত্র -কন্যা"){

                                        $agearray[]=$job->freedom_fighter;
                                    }
                                    if($quota=="ক্ষুদ্র নৃ -গোষ্ঠী"){
                                        $agearray[]=$job->freedom_fighter;

                                    }

                                    if($quota=="শারীরিক প্রতিবন্দী"){

                                        $agearray[]=$job->handicapped_age;
                                    }
                                    if($quota=="এতিম"){

                                        $agearray[]=$job->handicapped_age;
                                    }

                                  $maxage= max($agearray);

                }

                if($maxage > 0){

                    if(is_float($maxage)){
                      $agge=  explode('.', $maxage);
                      $whole=$agge[0];
                     if(!empty($agge[1])){
                        $decimal=$agge[1] ? $agge[1]:0;
                     }
                     else{
                        $decimal=0;
                     }

                   // list($whole, $decimal) = explode('.', $maxage);
                    $maxage=($whole*365)+($decimal*30);
                    }
                    else{

                        $maxage=$maxage*365;
                    }


                  }

                if((float)$total <= (float)$maxage){

                    return 'Yes';


                }
                else{
                    return 'No';
                }
        }








    }


}



//            $validator->sometimes('hscexamlevel', 'required', function () use ($job){
//                return $job->min_education=='HSC';
//            });
//            $validator->sometimes('hscexamlevel', 'required', function () use ($job){
//                return $job->min_education=='JSC';
//            });\

//            if($request->min_education_con=="OR"){
//
//            }
//            if($request->min_education_con=="AND"){
//
//            }

            /*
            if($request->min_education_con){
                //   dd($job->min_education, $job->min_education_con, $job->min_education_with);

                if($job->min_education=="JSC"){
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
                }

                elseif ($job->min_education=="SSC"){
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
                }
                elseif($job->min_education=="HSC"){
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

                }
                elseif($job->min_education=="Graduation"){
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

                }
                elseif($job->min_education=="Masters"){
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

                }

            }

            if($request->min_education_with){
                //   dd($job->min_education, $job->min_education_con, $job->min_education_with);

                if($job->min_education=="JSC"){
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
                }

                elseif ($job->min_education=="SSC"){
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
                }
                elseif($job->min_education=="HSC"){
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

                }
                elseif($job->min_education=="Graduation"){
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

                }
                elseif($job->min_education=="Masters"){
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

                }

            }
*/
