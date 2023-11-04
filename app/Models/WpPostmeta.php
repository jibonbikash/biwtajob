<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpPostmeta extends Model
{
    use HasFactory;
    protected $table = 'wp_postmeta';
    public $timestamps = false;
}
