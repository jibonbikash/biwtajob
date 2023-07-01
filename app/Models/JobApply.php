<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    use HasFactory;
    protected $fillable = ['job_id','applicants_id','token','bd_tk','received','txnid','txndate','roll','exam_hall','exam_date','exam_time','apply_date'];

    public function applicant()
    {
        return $this->hasOne(Applicant::class,'id','applicants_id');
    }


}
