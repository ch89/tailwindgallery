<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function store(User $user) {
		$data = request()->validate([
			"name" => "required",
			"avatar" => "image"
		]);

		if(request()->has("avatar")) {
			$data["avatar"] = request("avatar")->store("avatars");
		}

		$user->update($data);

		return $user;
	}
}
