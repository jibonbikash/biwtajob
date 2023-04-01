<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    protected $fillable = ['name','status','type'];

    public function Boards()
    {
        return $this->hasMany(ApplicantEducation::class,'id','board_university');
    }
}
