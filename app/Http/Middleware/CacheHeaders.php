<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        // Check if response was from cache
        $cacheKey = $this->generateCacheKey($request);
        $isFromCache = Cache::has($cacheKey);

        $response = $next($request);

        // Calculate response time in milliseconds
        $responseTime = round((microtime(true) - $startTime) * 1000);

        // Add response time header
        $response->headers->set('x-response-time', $responseTime);

        // Add cache status header
        $response->headers->set('x-cache', $isFromCache ? 'HIT' : 'MISS');

        return $response;
    }

    /**
     * Generate a unique cache key for the request
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    private function generateCacheKey(Request $request): string
    {
        $userId = auth()->id();
        $routeName = $request->route()->getName();
        $queryStringHash = md5($request->getQueryString());

        return "response_cache:{$routeName}:user_{$userId}:query_{$queryStringHash}";
    }
}
