<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;

class Discussion extends Model
{
    use HasFactory, Commentable;

    protected $primaryKey = "id";

    public $timestamps = false;
}
