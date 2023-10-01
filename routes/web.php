<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;

//rotas Notes
Route::middleware(['auth', 'verified'])->controller(NotesController::class)->group(function () {
    Route::resource('notes',);
    Route::post('/notes/{note}/check', 'check')->name('notes.check');
    Route::post('/notes/{note}/shared', 'shared')->name('notes.shared');
    Route::post('/notes/{note}/not-shared/{user}', 'notShared')->name('notes.not-shared');
});

//rotas Users
Route::middleware(['auth', 'verified'])->controller(UsersController::class)->group(function () {
    Route::get('/profile', 'profile')->name('profile');
});

//rotas Categories
Route::middleware(['auth', 'verified'])->controller(CategoriesController::class)->group(function () {
    Route::resource('categories',);
});

//rotas do sistema
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('notes.index');
    });
    Route::view('/error', 'includes.error')->name('error');
});

Route::view('/error', 'includes.error')->name('error');

Auth::routes(['verify' => true]);
