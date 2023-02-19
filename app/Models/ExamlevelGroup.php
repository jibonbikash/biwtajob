<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamlevelGroup extends Model
{
    use HasFactory;
    protected $fillable = ['examlevel_id','name','status'];

    public function examGroups()
    {
        return $this->belongsTo(Examlevel::class);
    }
    public function examSubject()
    {
        return $this->hasMany(ExamlevelSubject::class);
    }
}
