<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('notes.index');
    });
    Route::resource('notes', NotesController::class);
    Route::post('/notes/{note}/check', [NotesController::class, 'check'])->name('notes.check');
    Route::post('/notes/{note}/shared', [NotesController::class, 'shared'])->name('notes.shared');

    Route::resource('categories', CategoriesController::class);

    Route::view('/error', 'includes.error')->name('error');
});

Auth::routes();
