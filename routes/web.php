<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group( function () {
    Route::group(['prefix' => 'app'], function () {
        Route::get('/dashboard', function () {
            return view('private.dashboard');
        })->name('app.dashboard');

        Route::get('/usuarios', function() {
            return view('private.usuarios.listado');
        })->name('app.usuarios');
    });
});
