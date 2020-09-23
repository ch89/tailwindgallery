<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ["title", "content", "channel_id", "image", "comment_id"];
    // protected $with = ["channel", "comments.user"];
    protected $with = ["channel", "user"];
    protected $withCount = ["likes", "ratings", "comments"];
    protected $appends = ["liked", "rating", "average", "subscribed", "can"];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function channel() {
    	return $this->belongsTo(Channel::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->belongsToMany(User::class, "likes");
    }

    public function ratings() {
        return $this->belongsToMany(User::class, "ratings");
    }

    public function subscribers() {
        return $this->belongsToMany(User::class, "subscriptions");
    }

    public function getImageAttribute($image) {
    	return "/storage/$image";
    }

    public function getLikedAttribute() {
        return $this->likes()->where("user_id", auth()->id())->exists();
    }

    public function getRatingAttribute() {
        return $this->ratings()->where("user_id", auth()->id())->value("rating");
    }

    public function getAverageAttribute() {
        return round($this->ratings()->avg("rating"), 1);
    }

    public function getSubscribedAttribute() {
        return $this->subscribers()->where("user_id", auth()->id())->exists();
    }

    public function getCanAttribute() {
        return [
            "update" => Gate::allows("update", $this),
            "delete" => Gate::allows("delete", $this)
        ];
    }
}
