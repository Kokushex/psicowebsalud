<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_roles
 * @property int $name
 * @property string $created_at
 * @property string $updated_at
 * @property UserHasRole[] $userHasRoles
 */
class Roles extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_roles';

    /**
     * @var array
     */
    protected $fillable = ['name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userHasRoles()
    {
        return $this->hasMany('App\Models\UserHasRole', 'id_rol', 'id_roles');
    }
}
