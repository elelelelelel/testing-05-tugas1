<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $slug
 * @property Category $category
 */
class SubCategory extends Model
{
    use HasFactory, Notifiable;
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
    protected $fillable = ['category_id', 'name', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_sub_categories', 'user_id', 'role_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
