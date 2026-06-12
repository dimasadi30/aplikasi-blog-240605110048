<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // Prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Enable XSS filter
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Referrer policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // HSTS (production only)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }
        
        // Content Security Policy (basic)
        if (app()->environment('production')) {
            $csp = "default-src 'self'; "
                  . "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; "
                  . "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; "
                  . "img-src 'self' data: https:; "
                  . "font-src 'self' https://cdn.jsdelivr.net; "
                  . "connect-src 'self';";
            $response->headers->set('Content-Security-Policy', $csp);
        }
        
        return $response;
    }
}
