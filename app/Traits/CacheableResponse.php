<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Closure;

trait CacheableResponse
{
    /**
     * Cache the response for a given request
     *
     * @param Request $request
     * @param mixed $response
     * @param int $ttl Time to live in seconds
     * @return void
     */
    protected function cacheResponse(Request $request, $response, int $ttl = 3600): void
    {
        $cacheKey = $this->generateCacheKey($request);

        Cache::put($cacheKey, $response, $ttl);
    }

    /**
     * Get cached response for a request
     *
     * @param Request $request
     * @return mixed|null
     */
    protected function getCachedResponse(Request $request)
    {
        $cacheKey = $this->generateCacheKey($request);

        return Cache::get($cacheKey);
    }

    /**
     * Generate a unique cache key for the request
     *
     * @param Request $request
     * @return string
     */
    private function generateCacheKey(Request $request): string
    {
        $userId = auth()->id();
        $routeName = $request->route()->getName();
        $queryStringHash = md5($request->getQueryString());

        return "response_cache:{$routeName}:user_{$userId}:query_{$queryStringHash}";
    }

    /**
     * Process the request or return cached response
     *
     * @param Request $request
     * @param Closure $callback
     * @return mixed
     */
    public function processOrCache(Request $request, Closure $callback)
    {
        $cachedResponse = $this->getCachedResponse($request);

        if ($cachedResponse) {

            return $cachedResponse;
        }

        $response = $callback();

        $this->cacheResponse($request, $response);

        return $response;
    }
}
