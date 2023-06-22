<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property UserRole[] $userRoles
 */
class Role extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['name', 'title'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_roles', 'user_id', 'sub_category_id');
    }
}
