<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function educations()
    {
        return $this->hasMany(ApplicantEducation::class,'applicants_id','id');
    }
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function zila()
    {
        return $this->belongsTo(DistrictUpozilla::class,'pa_zilla','id');
    }

    public function birthplace()
    {
        return $this->belongsTo(DistrictUpozilla::class,'bplace','id');
    }
    public function apliyedJob()
    {
        return $this->hasOne(JobApply::class,'applicants_id','id');
    }

    public function upozilla()
    {
        return $this->belongsTo(DistrictUpozilla::class,'pa_upozilla','id');
    }
    public function permanentzila()
    {
        return $this->belongsTo(DistrictUpozilla::class,'pr_zilla','id');
    }
    public function permanentupozilla()
    {
        return $this->belongsTo(DistrictUpozilla::class,'pr_upozilla','id');
    }


}
