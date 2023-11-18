<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StaticValue;
use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\Wppost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MigrationController extends Controller
{
    //

    public function moveImage($currentPath, $destinationPath)
    {
        File::ensureDirectoryExists(dirname($destinationPath));
        File::copy($currentPath, $destinationPath);
    }

    public function index(Request $request)
    {
//        DELETE FROM `jb18_applicants` WHERE job_id > 14;
// DELETE FROM `jb18_jobs` WHERE id > 14;
// DELETE FROM `jb18_job_applies` WHERE job_id > 14;
        $jobs = Wppost::with(['JobMeta', 'applyJobs', 'Applicants', 'whoPost', 'ApplicantEducation'])->where(['post_type' => 'job', 'post_status' => 'publish'])->limit(10)->orderBy('ID', 'desc')->get();
      //  dd($jobs);

        DB::beginTransaction();
        try {

            foreach ($jobs as $job) {
                $divisioncaplicant_age = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_divisioncaplicant_age');
                $petition_age = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_petition_age');
                $handicapped_age = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_handicapped_age');
                $freedom_age = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_freedom_age');
                $minimum_age = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_minimum_age');
                $maximum_age = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_maximum_age');
                $vacancies = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_vacancies');
                //  $vacancies= collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_vacancies');
                $agecalculation = collect($job->JobMeta)->firstWhere('meta_key', 'jb_agecal');
                $experience = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_experience');
                $job_id = collect($job->JobMeta)->firstWhere('meta_key', 'jb_job_id');
                $apply_fee = collect($job->JobMeta)->firstWhere('meta_key', 'jb_apply_fee');
                $salary_range = collect($job->JobMeta)->firstWhere('meta_key', 'jb_salary_range');
                $application_dead = collect($job->JobMeta)->firstWhere('meta_key', 'jb_application_dead');
//dd($freedom_age->meta_value);

                $jobinfo = Job::create([
                    'uuid' => (string)Str::orderedUuid(),
                    'title' => $job->post_title,
                    'description' => $job->post_content,
                    'vacancies' => $vacancies ? $vacancies->meta_value : 1,
                    'job_id' => $job_id ? $job_id->meta_value : null,
                    'circular_no' => $job_id ? $job_id->meta_value : null,
                    'age_calculation' => date('Y-m-d', $agecalculation->meta_value),
                    'jobcurbday' => date('Y-m-d', strtotime($job->post_date)),
                    'apply_fee' => $apply_fee ? $apply_fee->meta_value : null,
                    'application_deadline' => date('Y-m-d H:i:s', $application_dead->meta_value),
                    'job_experience' => $experience ? $experience->meta_value : null,
                    'job_location' => null,
                    'freedom_age' => $freedom_age ? $freedom_age->meta_value : null,
                    'handicapped_age' => $handicapped_age ? $handicapped_age->meta_value : null,
                    'divisioncaplicant_age' => $divisioncaplicant_age ? $divisioncaplicant_age->meta_value : null,
                    'max_age' => $maximum_age ? $maximum_age->meta_value : null,
                    'min_age' => $minimum_age ? $minimum_age->meta_value : null,
                    'freedom_fighter' => $freedom_age ? $freedom_age->meta_value : null,
                    'petition_age' => $petition_age ? $petition_age->meta_value : null,
                    'salary_range' => $salary_range ? $salary_range->meta_value : null,
                    'min_education' => null,
                    'min_education_con' => null,
                    'min_education_with' => null,
                    'jsc' => false,
                    'ssc' => false,
                    'hsc' => false,
                    'graduation' => false,
                    'masters' => false,
                    'certificate_isrequired' => false,
                    'certificate' => "NO",
                    'certificate_text' => null,
                    'related_experience_text' => null,
                    'related_experience' => null,
                    'repetition' => null,
                    'minimum_job_experience' => $experience ? $experience->meta_value : null,
                    'status' => 1,
                ]);
                $jonID= StaticValue::BengaliToenglishNumberConverter(str_replace('/','_',$jobinfo->job_id));
               $JobYear= date('Y', strtotime($job->post_date));
                StaticValue::createDirecrotory($jonID,$JobYear );

                foreach ($job->applyJobs as $applyJobs) {
if($applyJobs->applicantInfo){
    echo $job->ID.'=='.$applyJobs->applicantInfo->id. '-'. $applyJobs->applicantInfo->picture.'<br />';
    $currentPath = public_path('applicants/'.$applyJobs->applicantInfo->picture);
    $destinationPath = public_path('assets/applicants/'.$JobYear.'/'.$jonID.'/'.$applyJobs->applicantInfo->picture);

    $currentPathsignature = public_path('applicants/'.$applyJobs->applicantInfo->signature);
    $destinationPathsignature = public_path('assets/applicants/'.$JobYear.'/'.$jonID.'/'.$applyJobs->applicantInfo->signature);

    //   dd($currentPath, $destinationPath);

    if (File::exists($currentPath))
    {
        $this->moveImage($currentPath, $destinationPath);
    }
    if (File::exists($currentPathsignature))
    {
         $this->moveImage($currentPathsignature, $destinationPathsignature);
    }

    $nameimage=$JobYear.'/'.$jonID.'/'.$applyJobs->applicantInfo->picture;
    $namesignature=$JobYear.'/'.$jonID.'/'.$applyJobs->applicantInfo->signature;

    $applicant= Applicant::create([
        'job_id' => $jobinfo->id,
        'uuid' => (string)Str::orderedUuid(),
        'name_bn' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->name_bn :'',
        'name_en' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->name_en:'',
        'nid' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->nid:'',
        'brn' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->brn:'',
        'bday' => $applyJobs->applicantInfo ? date('Y-m-d', strtotime($applyJobs->applicantInfo->bday)):'',
        'bplace' =>$applyJobs->applicantInfo ? $applyJobs->applicantInfo->bplace:'',
        'father_name' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->father_name:'',
        'mother_name' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->mother_name:'',
        'present_addrress' => null,
        'parmanent_address' => null,
        'mobile' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->mobile:'',
        'nationality' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->nationality:'',
        'gender' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->gender:'',
        'religious' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->religious:'',
        'extra_qualification' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->extra_qualification:'',
        'experience' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->experience:'',
        'bank_draft' => '',
        'bank_draft_date' => '',
        'bank_details' => '',
        'division_appli' =>$applyJobs->applicantInfo ? $applyJobs->applicantInfo->division_appli:'',
        'quota_freedom' => 0,
        'quota_tribal' => 0,
        'quota_Handicapped' => 0,
        'quota_orphanages' => 0,
        'village_police' => 0,
        'others_quota' => 0,
        'quota' => $request->input('quota') ? json_encode($request->input('quota')):NULL,
        'pa_house' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pa_house:'',
        'pa_village' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pa_village:'',
        'pa_union' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pa_union:'',
        'pa_postoffice' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pa_postoffice:'',
        'pa_postcode' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pa_postcode:'',
        'pa_upozilla' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pa_upozilla:'',
        'pa_zilla' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pa_zilla:'',
        'pr_house' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pr_house:'',
        'pr_village' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pr_village:'',
        'pr_union' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pr_union:'',
        'pr_postoffice' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pr_postoffice:'',
        'pr_postcode' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pr_postcode:'',
        'pr_upozilla' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pr_upozilla:'',
        'pr_zilla' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->pr_zilla:'',
        'occupation' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->occupation:'',
        'picture' => $applyJobs->applicantInfo ? $nameimage:'',
        'signature' => $applyJobs->applicantInfo ? $namesignature:'',
        'job_circular' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->job_circular:'',
        'experienceyear' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->job_circular:'',
        'experiencemonth' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->job_circular:'',
        'age' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->age:'',
        'code' => $applyJobs->applicantInfo ? $applyJobs->applicantInfo->code:'',
        'eligible' => 2,
        'repetition' => null,
        'jobcurday' => $applyJobs->applicantInfo ? date('Y-m-d', strtotime($applyJobs->applicantInfo->jobcurday)):'',
    ]);
    JobApply::create([
        'applicants_id'=> $applicant->id,
        'job_id'=> $jobinfo->id,
        'received'=> 1,
        'token'=> $applyJobs->token,
        'bd_tk'=> $applyJobs->bd_tk,
        'txnid'=> $applyJobs->txnid,
        'txndate'=> $applyJobs->txndate,
        'roll'=> $applyJobs->roll==0 ? null:$applyJobs->roll,
        'exam_hall'=> $applyJobs->exam_hall,
        'exam_date'=> $applyJobs->exam_date,
        'exam_time'=> $applyJobs->exam_time,
        'apply_date'=> $applyJobs->apply_date,

    ]);
}

                }

            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }
}
