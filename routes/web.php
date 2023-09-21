<?php

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\CategoriesController;

Route::middleware(['auth', 'verified'])->group(function () {
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

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = \App\Models\User::find($request->id);

    if ($request->hasValidSignature() && $user && !$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Email de verificação enviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
