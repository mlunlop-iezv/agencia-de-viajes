<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdvancedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user != null && ($user->rol == 'admin' || $user->rol == 'advanced')) {
            return $next($request);
        } else {
            return redirect()->route('main.index');
        }
    }
}