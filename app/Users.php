<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
class Users extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function direccionAtencions()
    {
        return $this->hasMany('App\Models\DireccionAtencion', 'id_user', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Models\Persona', 'id_user', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userHasRoles()
    {
        return $this->hasMany('App\Models\UserHasRole', 'id_user', 'id_user');
    }
}
