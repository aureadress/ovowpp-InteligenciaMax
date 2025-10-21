<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceWWW
{
    /**
     * Handle an incoming request.
     * 
     * Redirects non-www domain to www subdomain in production environment.
     * Example: inteligenciamax.com.br → www.inteligenciamax.com.br
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply in production environment
        if (!app()->environment('production')) {
            return $next($request);
        }

        $host = $request->getHost();
        
        // Check if host doesn't start with 'www.' and is not localhost
        if (!str_starts_with($host, 'www.') && !str_contains($host, 'localhost') && !str_contains($host, '127.0.0.1')) {
            // Build the new URL with www
            $newUrl = $request->getScheme() . '://www.' . $host . $request->getRequestUri();
            
            // 301 Permanent Redirect (SEO friendly)
            return redirect()->to($newUrl, 301);
        }
        
        return $next($request);
    }
}
