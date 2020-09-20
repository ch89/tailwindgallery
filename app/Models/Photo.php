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

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function channel() {
    	return $this->belongsTo(Channel::class);
    }

    public function getImageAttribute($image) {
    	return "/storage/$image";
    }
}
