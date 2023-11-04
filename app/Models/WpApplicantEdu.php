<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpApplicantEdu extends Model
{
    use HasFactory;
    protected $table = 'wp_applicant_edu';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(WpUsers::class, 'job_id','ID');
    }
    public function Job()
    {
        return $this->belongsTo(Wppost::class, 'job_id','ID');
    }
}
