<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemsController;
use App\Http\Controllers\Api\ProfileController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;





                //Public API's
 Route::post('/login',            [AuthController::class, 'login'])->name('user.login');
 Route::post('/user',             [UserController::class, 'store'])->name('user.store');



 //Private API's
 Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->group(function () {
         Route::post('/logout',        [ AuthController::class, 'logout']);

                // Items Routes
 Route::controller(ItemsController::class)->group(function () {
        Route::get('/item',        'index');
        Route::post('/item',        'store');
        Route::get('/item/{id}',   'show');
        Route::put('/item/{id}',   'update');
        Route::delete('/item/{id}','destroy');
    });


             //User Routes
 Route::controller(UserController::class)->group(function () {
        Route::get('/user',              'index');
        Route::get('/user/{id}',         'show');
        Route::put('/user/{id}',         'update')->name('user.update');
        Route::put('/user/email/{id}',   'email')->name('user.email');
        Route::put('/user/password/{id}','password')->name('user.password');
        Route::put('/user/image/{id}',   'image')->name('user.image');
        Route::delete('/user/{id}',      'destroy');
        });

    //User specific API's
        Route::get('/profile',          [ProfileController::class, 'show']);
        Route::put('/profile/image/',   [ProfileController::class, 'image'])->name('profile.image');
});     