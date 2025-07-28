<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    //
    protected $fillable = [
        'title',
        'url',
        'description',
        'image',
        'meta_title',
        'meta_description',
        'created_at'
    ];
}
