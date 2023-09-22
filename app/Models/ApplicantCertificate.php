<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantCertificate extends Model
{
    use HasFactory;
    protected $table = 'applicant_certificates';
    protected $guarded = [];
    public function Applicant()
    {
        return $this->belongsTo(Applicant::class,'applicants_id');
    }
}

// ALTER TABLE `jb18_applicant_certificates` ADD `certificate_no` VARCHAR(150) NOT NULL AFTER `duration`, ADD `certificate_expire` DATE NOT NULL AFTER `certificate_no`;