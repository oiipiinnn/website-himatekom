<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/about-us', function () {
    return view('about');
});
Route::get('/pengurus', function () {
    return view('pengurus');
});
Route::get('/pengurus/inti', function () {
    return view('pengurus.inti');
});
Route::get('/pengurus/internal', function () {
    return view('pengurus.internal');
});
Route::get('/pengurus/external', function () {
    return view('pengurus.external');
});
Route::get('/pengurus/risbang', function () {
    return view('pengurus.risbang');
});
Route::get('/blog', function () {
    return view('blog');
});
