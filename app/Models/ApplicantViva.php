<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantViva extends Model
{
    use HasFactory;
    protected $fillable = ['applicant_id','job_id','date','place','roll','time'];
    public function applicant()
    {
        return $this->belongsTo(Applicant::class,'applicant_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class,'job_id');
    }
}
