<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Job;
use App\Models\Wppost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MigrationController extends Controller
{
    //
    public function index(Request $request)
    {
        $jobs = Wppost::with(['JobMeta', 'applyJobs', 'Applicants', 'whoPost', 'ApplicantEducation'])->where(['post_type' => 'job', 'post_status' => 'publish'])->limit(2)->orderBy('ID', 'desc')->get();
        dd($jobs[0]);

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
                foreach ($job->applyJobs as $applyJobs) {

                    $applicant= Applicant::create([
                        'job_id' => $jobinfo->id,
                        'uuid' => (string)Str::orderedUuid(),
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
                }

            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }
}
