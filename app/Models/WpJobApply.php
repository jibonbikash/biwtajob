<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpJobApply extends Model
{
    use HasFactory;
    protected $table = 'wp_job_apply';

    public function user()
    {
        return $this->belongsTo(WpUsers::class, 'user_id','ID');
    }
    public function applicantInfo()
    {
        return $this->belongsTo(WpApplicantInfo::class, 'user_id','user_id');
    }
}
