<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examlevel extends Model
{
    use HasFactory;
    protected $fillable = ['name','status'];

    public function examGroups()
    {
        return $this->hasMany(ExamlevelGroup::class);
    }
}
