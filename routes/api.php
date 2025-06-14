<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;




 Route::post('/user',            [UserController::class, 'store'])->name('user.store');