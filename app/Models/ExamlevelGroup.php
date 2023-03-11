<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamlevelGroup extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['examlevel_id','name','status'];

    public function examLevel()
    {
        return $this->belongsTo(Examlevel::class,'examlevel_id', 'id');
    }
    public function examSubject()
    {
        return $this->hasMany(ExamlevelSubject::class);
    }
}
