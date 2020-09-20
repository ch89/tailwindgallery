<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ["title", "content", "channel_id", "image"];
    protected $with = ["channel"];
    protected $withCount = ["likes", "ratings"];
    protected $appends = ["liked", "rating", "average"];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function channel() {
    	return $this->belongsTo(Channel::class);
    }

    public function likes() {
        return $this->belongsToMany(User::class, "likes");
    }

    public function ratings() {
        return $this->belongsToMany(User::class, "ratings");
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
}
