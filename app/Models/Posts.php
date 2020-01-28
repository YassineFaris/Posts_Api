<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = [
        'title',
        'text',
        'image',
        'created_by',
        'published_by',
        'is_published',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $table = 'posts';
    protected $primaryKey = 'id';
}
