<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'libelle_role',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $table = 'roles';
    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
