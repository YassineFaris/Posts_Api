<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategories extends Model
{
    protected $fillable = [
        'id_post',
        'id_categorie',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $table = 'post_categories';
    protected $primaryKey = 'id';
}
