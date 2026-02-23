<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('Incoming Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'has_user' => $request->user() ? true : false,
            'user_id' => $request->user()->id ?? null,
            'user_role' => $request->user()->role ?? null,
            'headers' => $request->headers->all(),
            'input' => $request->except(['password', 'file']),
            'has_file' => $request->hasFile('file')
        ]);

        $response = $next($request);

        \Log::info('Outgoing Response', [
            'status' => $response->getStatusCode(),
            'url' => $request->fullUrl(),
            'content_type' => $response->headers->get('content-type')
        ]);

        return $response;
    }
}
