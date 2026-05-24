<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserLevel
{
    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (!Auth::check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        if (!in_array(Auth::user()->level, $levels)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
