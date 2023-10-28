<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class ApplicantExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        return Applicant::all();
//    }
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $request = $this->request;
        $q=$request['q'] ?? null;
        $job_id=$request['job_id'] ?? null;
        $code=$request['code'] ?? null;
        $gender=$request['gender'] ?? null;
        $religion=$request['religion'] ?? null;
        $education=$request['education'] ?? null;
        $minimum_age=$request['minimum_age'] ?? null;
        $maximum_age=$request['maximum_age'] ?? null;
        $experience=$request['experience'] ?? null;
        $certification=$request['certification'] ?? null;
        $quota=$request['quota'] ?? null;

       $applicants= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','apliyedJob'])
            ->whereIn('applicants.eligible',[1,2])
        ->when($job_id, function ($query) use ($job_id){
        $query->where('job_id', $job_id);
    })
           ->when($q, function ($q1) use ($q){
               $q1->where(function ($query) use ($q){
                   $query->where('name_en','like', '%'.$q.'%')
                       ->orWhere('name_bn', 'like', '%'.$q.'%')
                       ->orWhere('nid', 'like', '%'.$q.'%')
                       ->orWhere('mobile', 'like', '%'.$q.'%');
               });
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
            ->latest()->get();
        return view('exports.applicants', [
            'applicants' =>$applicants
        ]);
    }


}
