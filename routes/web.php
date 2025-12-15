<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function (Request $request) {
    return view('welcome');
});

$_GET['name']; super‑globals bypass everything, use Laravel $request object
$request->all() ou ->input('nom')
*/


Route::get('/', function () {
    return redirect('/signin');
});

Route::get('/signin', [LoginController::class, 'show']);
