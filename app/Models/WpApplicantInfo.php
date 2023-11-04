<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpApplicantInfo extends Model
{
    use HasFactory;
    protected $table = 'wp_applicant_info';
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
