<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Owner
{
    public function handle(Request $request, Closure $next)
    {
        $note = $request->route('note');
        if ($note->user_id == Auth::user()->id || Auth::user()->is_admin == 1 || $note->shared->contains(Auth::user()->id)) {
            return $next($request);
        } else {
            abort('404');
        }
    }
}
