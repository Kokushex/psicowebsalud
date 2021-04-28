<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_user_roles
 * @property int $id_rol
 * @property int $id_user
 * @property string $created_at
 * @property string $updated_at
 * @property Role $role
 * @property User $user
 */
class UserHasRoles extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_user_roles';

    /**
     * @var array
     */
    protected $fillable = ['id_rol', 'id_user', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'id_rol', 'id_roles');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id_user');
    }
}
