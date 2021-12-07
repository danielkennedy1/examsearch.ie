<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyComment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];
    protected $table ="mycomments";

     /**
     * The user who posted the comment.
     */
    public function commenter()
    {
        return $this->morphTo();
    }

}
