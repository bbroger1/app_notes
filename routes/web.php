<?php

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('notes.index');
    });
    Route::resource('notes', NotesController::class);
    Route::post('/notes/{note}/check', [NotesController::class, 'check'])->name('notes.check');
    Route::post('/notes/{note}/shared', [NotesController::class, 'shared'])->name('notes.shared');

    Route::resource('categories', CategoriesController::class);

    Route::get('/profile', [UsersController::class, 'profile'])->name('profile');

    Route::view('/error', 'includes.error')->name('error');
});

Auth::routes(['verify' => true]);
