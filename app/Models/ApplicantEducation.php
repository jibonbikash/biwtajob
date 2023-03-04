<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEducation extends Model
{
    use HasFactory;
    protected $table = 'applicant_educations';
    protected $guarded = [];
    public function examLevelGroups()
    {
        return $this->belongsTo(ExamlevelGroup::class,'edu_level');
    }

    public function ExamlevelSubject()
    {
        return $this->belongsTo(ExamlevelSubject::class,'group_subject');
    }
}
