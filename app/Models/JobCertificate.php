<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCertificate extends Model
{
    use HasFactory;
    protected $fillable = ['job_id','certificate_id'];

    public function job()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function certificate()
    {
        return $this->belongsTo(Crtificate::class,'certificate_id');
    }

}
