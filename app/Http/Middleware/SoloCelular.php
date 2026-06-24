<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloCelular
{
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->userAgent();

        $mobilePatterns = ['Mobile', 'Android', 'iPhone', 'iPad'];

        foreach ($mobilePatterns as $pattern) {
            if (str_contains($userAgent, $pattern)) {
                return redirect('/movil');
            }
        }

        return $next($request);
    }
}
