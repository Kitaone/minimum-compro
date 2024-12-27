<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Homecontroller;

// Route::get('/', function () {
// 	return view('welcome');
// });
Route::get('/', [Homecontroller::class, 'index'])->name('home-index');
