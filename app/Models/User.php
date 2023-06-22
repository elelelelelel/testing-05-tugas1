<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'university',
        'job',
        'orcid_id',
        'scopus_url',
        'sinta_url',
        'verified_token',
        'avatar',
        'gender',
        'status',
        'slug',
        'sub_category_id',
        'balance',
        'similarity',
        'reviewer_approved_at',
        'reviewer_declined_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verified_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->verified_token = Str::random(40);
        });
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function assign($role)
    {
        $role_id = \App\Models\Role::firstOrCreate([
            'name' => $role
        ], [
            'title' => ucwords($role)
        ])->id;
        return $this->roles()->syncWithoutDetaching($role_id);
    }

    public function retract($role)
    {
        $check = \App\Models\Role::where('name', $role)->first();
        if (!is_null($check)) {
            $this->roles()->detach($check->id);
            return true;
        }
        throw new \Exception("Role Not Found");
    }

    public function isAn($role)
    {
        return in_array($role, $this->roles->pluck('name')->toArray());
    }

    public function isA($role)
    {
        return $this->isAn($role);
    }

    public function isNotA($role)
    {
        return !$this->isA($role);
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function confirmEmail()
    {
        $this->email_verified_at = Carbon::now();

        $this->save();
    }

    public function getAvatarUrlAttribute()
    {
        if (!is_null($this->avatar)) {
            return $this->avatar;
        }
        return asset('assets/dashboard/img/avatar/avatar-1.png');
    }

    public function auctions()
    {
        return $this->hasMany('App\Models\AuctionDetail');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'editor_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Order', 'reviewer_id');
    }

    public function getRateAttribute()
    {
        if ($this->reviews()->whereNotNull('done_at')->count() > 0) {
            $rate_user = $this->reviews()->avg('rate');
            $rate_admin = $this->reviews()->avg('rate_admin');
            return ($rate_user + $rate_admin) / 2;
        }
        return 3;
    }

    public function getRateWithoutAdminAttribute()
    {
        if ($this->reviews()->whereNotNull('done_at')->count() > 0) {
            $rate_user = $this->reviews()->avg('rate');
            return $rate_user;
        }
        return 3;
    }

    public function subCategories()
    {
        return $this->belongsToMany('App\Models\SubCategory', 'user_sub_categories', 'user_id', 'sub_category_id');
    }

    public function withdraws()
    {
        return $this->hasMany('App\Models\Withdraw');
    }
}
