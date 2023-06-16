<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showFormLogin()
    {
        return view("home");
    }
    public function login()
    {
        return view("home");
    }

    public function loginWithId($id)
    {
        Auth::loginUsingId($id);
        return redirect()->route("chat");
    }
}
