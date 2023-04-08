<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['uuid','title','description','vacancies','job_id','age_calculation','apply_fee','job_experience','freedom_age','handicapped_age',
        'divisioncaplicant_age','max_age','min_age','freedom_fighter','petition_age','application_deadline','min_education', 'min_education_con','min_education_with',
        'jsc','ssc','hsc','graduation','masters','status','jobcurbday','certificate','certificate_isrequired'];
    protected $notFoundMessage = 'The book could not be found';
    public function applicants()
    {
        return $this->hasMany(Applicant::class,'job_id');
    }
    public function certificates()
    {
        return $this->hasMany(JobCertificate::class,'job_id');
    }
    public function examSubject()
    {
        return $this->hasMany(JobExamSubject::class,'job_id');
    }
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
    public function scopeActiveJobs($query)
    {
        $query->whereDate('application_deadline','>=',date('Y-m-d') );
    }
}
