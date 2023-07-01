<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApply;
use App\Rules\OldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class DashboardController extends Controller
{
    public function index(Request $request){

        $jobs= Job::active()->activeJobs()->count();
        $jobsAll= Job::active()->count();

        $applicants = DB::table('applicants')
        ->join('job_applies', 'applicants.id', '=', 'job_applies.applicants_id')
        ->join('jobs', function (JoinClause $join) {
        $join->on('applicants.job_id', '=', 'jobs.id')->On('job_applies.job_id', '=', 'jobs.id');
    })
        ->select('applicants.*', 'job_applies.token', 'jobs.title as job_title', 'job_applies.received as received', 'job_applies.txnid as txnid', 'job_applies.txndate as txndate', 'job_applies.roll as roll',
        'job_applies.exam_hall as exam_hall','job_applies.exam_date as exam_date','job_applies.exam_time as exam_time', 'job_applies.exam_time as apply_date',
        'jobs.age_calculation as age_calculation',
        )
        ->whereNull('applicants.deleted_at')
        ->whereNull('job_applies.deleted_at')
        ->whereIn('applicants.eligible',[1,2])
        ->count();

        $TakaReceived= JobApply::where('received', 1)->whereNotNull('txnid')->sum('bd_tk');

        return view('dashboard',['jobsAll'=>$jobsAll, 'activeJobs'=>$jobs, 'applicants'=>$applicants, 'TakaReceived'=>$TakaReceived]);
    }

    public function profile(Request $request)
    {

        return view("admin.profile");
    }
    public function password(Request $request)
    {

        return view("admin.password");
    }

    public function passwordchange(Request $request)
    {

        $request->validate([
            'current_password' => ['required', new OldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            User::find(Auth::guard('web')->user()->id)->update(['password' => Hash::make($request->new_password)]);

            return redirect()->route('dashboard')
                ->with('success', 'Password updated successfully');

        } catch (\Exception $e) {

            return redirect()->route('dashboard')
                ->with('error', $e->getMessage());

        }


    }
}
