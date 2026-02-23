<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware configuration
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        
        // Enable CORS and request logging
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\LogRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling with detailed error messages
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'กรุณาเข้าสู่ระบบก่อนใช้งาน',
                    'error_type' => 'authentication_required',
                    'debug' => [
                        'url' => $request->path(),
                        'method' => $request->method()
                    ]
                ], 401);
            }
        });
        
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'ข้อมูลไม่ถูกต้อง: ' . $e->validator->errors()->first(),
                    'errors' => $e->validator->errors(),
                    'error_type' => 'validation_error'
                ], 422);
            }
        });
        
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่พบหน้าที่ต้องการ (404)',
                    'error_type' => 'not_found',
                    'debug' => [
                        'url' => $request->path(),
                        'method' => $request->method()
                    ]
                ], 404);
            }
        });
    })
    ->create();
