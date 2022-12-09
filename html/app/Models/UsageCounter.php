<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageCounter extends Model
{
    protected $table = "usage_counter";
    protected $connection = "mysql";
    protected $fillable = ["exam", "subject", "year", "uses"];
    public $timestamps = false;
}
