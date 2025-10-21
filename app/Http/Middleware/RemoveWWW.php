<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveWWW
{
    /**
     * Handle an incoming request.
     * 
     * Redirects www subdomain to non-www domain in production environment.
     * Example: www.inteligenciamax.com.br → inteligenciamax.com.br
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
        
        // Check if host starts with 'www.'
        if (str_starts_with($host, 'www.')) {
            // Remove 'www.' from host
            $newHost = substr($host, 4);
            
            // Build the new URL without www
            $newUrl = $request->getScheme() . '://' . $newHost . $request->getRequestUri();
            
            // 301 Permanent Redirect (SEO friendly)
            return redirect()->to($newUrl, 301);
        }
        
        return $next($request);
    }
}
