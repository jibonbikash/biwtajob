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
        'jsc','ssc','hsc','graduation','masters','status','jobcurbday','certificate','certificate_isrequired','related_experience_text','certificate_text','related_experience','repetition','minimum_job_experience',
 'graduation_result','masters_result'
    ];
    protected $notFoundMessage = 'The Job could not be found';
    public function applicants()
    {
        return $this->hasMany(Applicant::class,'job_id')->whereIn('eligible',[1,2]);
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

    public function getNameAttribute() {
        return ucwords($this->title . ' (' . $this->job_id.')');
    }

}

// ALTER TABLE `jb18_jobs` ADD `related_experience_text` VARCHAR(150) NULL AFTER `certificate_isrequired`, ADD `related_experience` VARCHAR(150) NULL AFTER `related_experience_text`, ADD `repetition` VARCHAR(150) NULL AFTER `related_experience`;

// ALTER TABLE `jb18_jobs` ADD `minimum_job_experience` INT NOT NULL AFTER `repetition`;

// ALTER TABLE `jb18_jobs` ADD `quota` VARCHAR(150) NULL AFTER `minimum_job_experience`;
// ALTER TABLE `jb18_jobs` ADD `graduation_result` VARCHAR(500) NULL AFTER `quota`, ADD `masters_result` VARCHAR(500) NULL AFTER `graduation_resulr`;
