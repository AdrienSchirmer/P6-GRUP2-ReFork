<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class is_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role !== 'admin') {
            Inertia::flash([
                'unauthorized' => true,
                'title' => 'Accés Denegat',
                'message' => 'No tens permisos per accedir a aquesta pàgina.',
            ]);

            return to_route('home');
        }

        return $next($request);
    }
}
