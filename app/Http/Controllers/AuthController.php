<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct() {
    	$this->middleware("auth:api")->except(["register", "login"]);
    }

    public function register() {
    	$data = request()->validate([
    		"name" => "required",
    		"email" => "required|email|unique:users",
    		"password" => "required"
    	]);

    	$data["password"] = bcrypt($data["password"]);

    	$user = User::create($data);

    	$token = auth()->login($user);

    	return [
    		"token" => $token,
    		"user" => auth()->user()
    	];
    }

    public function login() {
        $token = auth()->attempt(request()->validate([
            "email" => "required",
            "password" => "required"
        ]));

        if($token) {
            return [
                "token" => $token,
                "user" => auth()->user()
            ];
        }
        else {
            return response()->json(["error" => "Invalid email or password"], 401);
        }
    }

    public function logout() {
        auth()->logout();
    }
}
