<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wppost extends Model
{
    use HasFactory;
    protected $table = 'wp_posts';
    public $timestamps = false;

    public function Applicants()
    {
        return $this->hasMany(WpApplicantInfo::class, 'job_id','ID');
    }
    public function ApplicantEducation()
    {
        return $this->hasMany(WpApplicantEdu::class, 'job_id', 'ID');
    }
        public function whoPost()
    {
        return $this->belongsTo(WpUsers::class, 'post_author','ID');
    }

    public function applyJobs()
    {
        return $this->hasMany(WpJobApply::class, 'job_id', 'ID')->whereNotNull('txndate')->whereNotNull('txnid')->where('received','=', 1);
    }
    public function JobMeta()
    {
        return $this->hasMany(WpPostmeta::class, 'post_id', 'ID');
    }
}
