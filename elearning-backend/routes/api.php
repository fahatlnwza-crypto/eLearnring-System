<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'message' => 'API is running',
        'timestamp' => now()
    ]);
});

// Public authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthApiController::class, 'login']);
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/refresh', [AuthApiController::class, 'refresh']);
    
    // Social login routes
    Route::get('/{provider}/redirect', [AuthApiController::class, 'redirectToProvider'])
        ->where('provider', 'google|facebook');
    Route::get('/{provider}/callback', [AuthApiController::class, 'handleProviderCallback'])
        ->where('provider', 'google|facebook');
});

// Protected authentication routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    Route::get('/auth/me', [AuthApiController::class, 'me']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Test endpoint for debugging auth
    Route::get('/test-auth', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Authentication working!',
            'user' => $request->user(),
            'role' => $request->user()->role
        ]);
    });
});

// Test endpoint for role middleware
Route::middleware(['auth:sanctum', 'role:teacher,admin'])->group(function () {
    Route::get('/test-role', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Role middleware working!',
            'user' => $request->user(),
            'role' => $request->user()->role
        ]);
    });
});

// Media routes for teachers
Route::middleware(['auth:sanctum', 'role:teacher,admin'])->group(function () {
    Route::post('/media', [\App\Http\Controllers\MediaController::class, 'store']);
    Route::post('/media/{id}', [\App\Http\Controllers\MediaController::class, 'update']); // Changed to POST for file upload
    Route::delete('/media/{id}', [\App\Http\Controllers\MediaController::class, 'destroy']);
});

// Media routes for all authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/media', [\App\Http\Controllers\MediaController::class, 'index']);
    Route::get('/media/{id}', [\App\Http\Controllers\MediaController::class, 'show']);
    Route::get('/media/{id}/download', [\App\Http\Controllers\MediaController::class, 'download']);
    Route::get('/media/category/{category}', [\App\Http\Controllers\MediaController::class, 'getByCategory']);
    Route::get('/media/type/{type}', [\App\Http\Controllers\MediaController::class, 'getByType']);
});
