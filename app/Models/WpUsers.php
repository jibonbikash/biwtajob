<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpUsers extends Model
{
    use HasFactory;
    protected $table = 'wp_users';
    public $timestamps = false;
}
