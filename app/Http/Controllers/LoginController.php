<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function show() { return view('signin', ['qui' => "passe partout"]); }
}
