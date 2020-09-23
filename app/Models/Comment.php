<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ["content", "user_id"];
    protected $with = ["user"];
    protected $appends = ["can"];

    public function photo() {
    	return $this->belongsTo(Photo::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value) {
    	return Carbon::parse($value)->diffForHumans();
    }

    public function getCanAttribute() {
        return ["delete" => Gate::allows("delete", $this)];
    }
}
