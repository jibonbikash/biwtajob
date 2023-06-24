<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crtificate extends Model
{
    use HasFactory;
    protected $table = 'certificates';
    protected $fillable = ['name','status'];
}
