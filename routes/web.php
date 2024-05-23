<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tyn', function () {
    return "Hello Christian";
});

Route::redirect('/youtube', '/tyn');

Route::fallback(function () {
    return "404";
});

Route::view('/hello', 'hello', ['name' => 'Christian']);

Route::get('/hello-again', function () {
    return view('hello', ['name' => 'Christian']);
});

Route::get('/hello-world', function () {
    return view('hello.world', ['name' => 'Christian']);
});