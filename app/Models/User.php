<?php

namespace App\Models;

use App\Models\DireccionAtencion;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id_user
 * @property string $email
 * @property string $password
 * @property string $rememberToken
 * @property string $avatar
 * @property string $provider_id
 * @property string $provider
 * @property string $email_verified_at
 * @property boolean $status
 * @property string $updated_at
 * @property string $created_at
 * @property DireccionAtencion[] $direccionAtencions
 * @property Persona[] $personas
 * @property UserHasRole[] $userHasRoles
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * @var array
     */
    protected $fillable = ['email', 'password', 'rememberToken', 'avatar', 'provider_id', 'provider', 'email_verified_at', 'status', 'updated_at', 'created_at'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function direccionAtencions()
    {
        return $this->hasMany('App\DireccionAtencion', 'id_user', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Persona', 'id_user', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userHasRoles()
    {
        return $this->hasMany('App\UserHasRole', 'id_user', 'id_user');
    }
}
