<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            \Log::warning('Unauthorized access attempt', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'กรุณาเข้าสู่ระบบก่อนใช้งาน',
                'error_type' => 'unauthorized',
                'debug' => [
                    'required_authentication' => true,
                    'url' => $request->path()
                ]
            ], 401);
        }

        $userRole = $request->user()->role;

        if (!in_array($userRole, $roles)) {
            \Log::warning('Forbidden access attempt', [
                'user_id' => $request->user()->id,
                'user_role' => $userRole,
                'required_roles' => $roles,
                'url' => $request->fullUrl()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์ใช้งานฟีเจอร์นี้ (ต้องเป็น ' . implode(' หรือ ', $roles) . ')',
                'error_type' => 'forbidden',
                'debug' => [
                    'your_role' => $userRole,
                    'required_roles' => $roles,
                    'user_id' => $request->user()->id
                ]
            ], 403);
        }

        return $next($request);
    }
}
