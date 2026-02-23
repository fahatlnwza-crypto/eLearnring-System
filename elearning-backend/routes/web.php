<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel API Backend',
        'version' => '1.0.0'
    ]);
});

// Handle OPTIONS request for CORS preflight
Route::options('/storage/media/{filename}', function () {
    return response('', 200, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
        'Access-Control-Allow-Headers' => '*',
        'Access-Control-Max-Age' => '86400',
    ]);
})->where('filename', '.*');

// Serve media files with proper CORS headers and range request support
Route::get('/storage/media/{filename}', function ($filename) {
    $path = storage_path('app/public/media/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    $fileSize = filesize($path);
    $mimeType = mime_content_type($path);
    
    // Optimize cache headers for video streaming
    $headers = [
        'Accept-Ranges' => 'bytes',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
        'Access-Control-Allow-Headers' => '*',
        'Access-Control-Expose-Headers' => 'Accept-Ranges, Content-Length, Content-Range',
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=2592000, immutable', // 30 days cache
        'X-Content-Type-Options' => 'nosniff',
    ];
    
    $rangeHeader = request()->header('Range');
    
    if ($rangeHeader) {
        // Parse range header for seeking through video
        preg_match('/bytes=(\d+)-(\d*)/', $rangeHeader, $matches);
        $start = intval($matches[1]);
        $end = !empty($matches[2]) ? intval($matches[2]) : min($start + 5242880, $fileSize - 1); // Load 5MB chunks for better seeking
        
        if ($start > $end || $start >= $fileSize) {
            return response('', 416, ['Content-Range' => "bytes */$fileSize"]);
        }
        
        $length = $end - $start + 1;
        $file = fopen($path, 'rb');
        fseek($file, $start);
        $data = fread($file, $length);
        fclose($file);
        
        $headers['Content-Range'] = "bytes $start-$end/$fileSize";
        $headers['Content-Length'] = $length;
        
        return response($data, 206, $headers);
    }
    
    // No range request, return full file
    return response()->file($path, array_merge($headers, [
        'Content-Length' => $fileSize,
    ]));
})->where('filename', '.*');
