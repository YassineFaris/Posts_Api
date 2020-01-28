<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'nom_user',
        'prenom_user',
        'phone_user',
        'email_user',
        'password_user',
        'id_role',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'password_user'
    ];

    protected $table = 'users';
    protected $primaryKey = 'id';

    public function getAuthPassword()
    {
        return $this->attributes['password_user'];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return
        [
            'id_user'=> Crypt::encryptString($this->id),
            'id_role'=> Crypt::encryptString($this->id_role)
        ];
    }


    public function roles()
    {
        return $this->hasOne('App\Models\Role');
    }

}
