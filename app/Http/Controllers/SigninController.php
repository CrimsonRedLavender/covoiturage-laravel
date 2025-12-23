<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class SigninController extends Controller
{
    public function show() { return view('./signin/signin'); }
}
