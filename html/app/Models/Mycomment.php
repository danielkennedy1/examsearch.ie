<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mycomment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];
    protected $tableName ="mycomments";

     /**
     * The user who posted the comment.
     */
    public function commenter()
    {
        return $this->morphTo();
    }

}
