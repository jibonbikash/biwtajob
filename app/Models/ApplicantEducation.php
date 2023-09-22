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

// ALTER TABLE `jb18_applicant_educations` CHANGE `result` `result` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `cgpa` `cgpa` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `out_of` `out_of` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;