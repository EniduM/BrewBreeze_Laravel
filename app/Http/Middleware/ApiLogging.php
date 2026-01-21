<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLogging
{
    /**
     * Handle an incoming request and log API usage.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        // Log incoming API request
        Log::channel('api')->info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => $request->user()?->id,
            'timestamp' => now()->toISOString(),
        ]);

        $response = $next($request);

        $duration = round((microtime(true) - $startTime) * 1000, 2); // Duration in milliseconds

        // Log API response
        Log::channel('api')->info('API Response', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => $duration,
            'user_id' => $request->user()?->id,
            'timestamp' => now()->toISOString(),
        ]);

        // Add custom headers to response
        $response->headers->set('X-Response-Time', $duration . 'ms');
        $response->headers->set('X-API-Version', 'v1');

        return $response;
    }
}
