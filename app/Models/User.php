<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ["followed"];

    public function photos() {
        return $this->hasMany(Photo::class);
    }

    public function likes() {
        return $this->belongsToMany(Photo::class, "likes");
    }

    public function ratings() {
        return $this->belongsToMany(Photo::class, "ratings");
    }

    public function subscriptions() {
        return $this->belongsToMany(Photo::class, "subscriptions");
    }

    public function following() {
        return $this->belongsToMany(static::class, "follows", "follower_id", "followed_id");
    }

    public function followers() {
        return $this->belongsToMany(static::class, "follows", "followed_id", "follower_id");
    }

    public function getFollowedAttribute() {
        return $this->followers()->where("follower_id", auth()->id())->exists();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarAttribute($avatar) {
        return "/storage/$avatar";
    }
}
