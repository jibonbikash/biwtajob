<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamlevelSubject extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['examlevel_id', 'examlevel_group_id','name','status'];

    public function examGroup()
    {
        return $this->belongsTo(ExamlevelGroup::class);
    }
    public function examlevel()
    {
        return $this->belongsTo(Examlevel::class);
    }
}
