<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobExam extends Model
{
    use HasFactory;
    protected $fillable = ['job_id','examlevel_group_id','type'];
}
