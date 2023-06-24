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
