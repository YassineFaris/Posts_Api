<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'title',
        'description',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $table = 'categories';
    protected $primaryKey = 'id';
}
