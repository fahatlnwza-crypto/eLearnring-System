<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Jobs\TranscodeVideoJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    /**
     * Display a listing of media (all published for students, all for teachers)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $searchQuery = $request->input('search', '');
        
        // If teacher, show all their media
        if ($user->isTeacher() || $user->isAdmin()) {
            $query = Media::where('teacher_id', $user->id);
            
            // Add search functionality
            if (!empty($searchQuery)) {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('title', 'like', '%' . $searchQuery . '%')
                      ->orWhere('description', 'like', '%' . $searchQuery . '%')
                      ->orWhere('category', 'like', '%' . $searchQuery . '%');
                });
            }
            
            $media = $query->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            // If student, show only published media
            $query = Media::where('status', 'published')
                ->with('teacher:id,firstname,lastname,username');
            
            // Add search functionality
            if (!empty($searchQuery)) {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('title', 'like', '%' . $searchQuery . '%')
                      ->orWhere('description', 'like', '%' . $searchQuery . '%')
                      ->orWhere('category', 'like', '%' . $searchQuery . '%');
                });
            }
            
            $media = $query->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return response()->json([
            'success' => true,
            'data' => $media
        ], 200);
    }

    /**
     * Store a newly created media
     */
    public function store(Request $request)
    {
        try {
            // Log request for debugging
            \Log::info('Media upload request received', [
                'user_id' => $request->user()->id,
                'user_role' => $request->user()->role,
                'has_file' => $request->hasFile('file'),
                'request_data' => $request->except(['file'])
            ]);

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'media_type' => 'required|in:video,document,image,audio,other',
                'category' => 'nullable|string|max:255',
                'file' => 'required|file|max:524288', // 512MB max
                'status' => 'required|in:draft,published',
            ], [
                'title.required' => 'กรุณากรอกชื่อเรื่อง',
                'media_type.required' => 'กรุณาเลือกประเภทสื่อ',
                'media_type.in' => 'ประเภทสื่อไม่ถูกต้อง',
                'file.required' => 'กรุณาเลือกไฟล์',
                'file.file' => 'ไฟล์ที่เลือกไม่ถูกต้อง',
                'file.max' => 'ไฟล์มีขนาดใหญ่เกินไป (สูงสุด 512MB)',
                'status.required' => 'กรุณาเลือกสถานะ',
                'status.in' => 'สถานะไม่ถูกต้อง'
            ]);

            if ($validator->fails()) {
                \Log::warning('Media upload validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'ข้อมูลไม่ถูกต้อง: ' . $validator->errors()->first(),
                    'errors' => $validator->errors(),
                    'debug' => [
                        'received_fields' => array_keys($request->except(['file'])),
                        'has_file' => $request->hasFile('file')
                    ]
                ], 422);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('media', $fileName, 'public');

            if (!$filePath) {
                \Log::error('Failed to store file', [
                    'file_name' => $fileName
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่สามารถบันทึกไฟล์ได้ กรุณาตรวจสอบสิทธิ์การเขียนไฟล์',
                    'debug' => [
                        'storage_path' => storage_path('app/public/media'),
                        'file_name' => $fileName
                    ]
                ], 500);
            }

            $media = Media::create([
                'teacher_id' => $request->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'media_type' => $request->media_type,
                'category' => $request->category,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'status' => $request->status,
            ]);

            \Log::info('Media uploaded successfully', [
                'media_id' => $media->id,
                'user_id' => $request->user()->id
            ]);

            // Dispatch video transcoding job if media type is video
            if ($media->media_type === 'video') {
                \Log::info('Dispatching video transcoding job', ['media_id' => $media->id]);
                TranscodeVideoJob::dispatch($media);
            }

            return response()->json([
                'success' => true,
                'message' => 'อัปโหลดสื่อสำเร็จ' . ($media->media_type === 'video' ? ' (กำลังประมวลผลวิดีโอเป็นหลายคุณภาพ)' : ''),
                'data' => $media
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Media upload failed with exception', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage(),
                'error_type' => get_class($e),
                'debug' => [
                    'file' => basename($e->getFile()),
                    'line' => $e->getLine(),
                    'user_id' => $request->user()->id ?? null,
                    'user_role' => $request->user()->role ?? null
                ]
            ], 500);
        }
    }

    /**
     * Display the specified media
     */
    public function show(Request $request, $id)
    {
        $media = Media::with('teacher:id,firstname,lastname,username')->find($id);

        if (!$media) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบสื่อที่ต้องการ'
            ], 404);
        }

        // Check permission
        $user = $request->user();
        if ($media->status === 'draft' && $media->teacher_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์เข้าถึงสื่อนี้'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $media
        ], 200);
    }

    /**
     * Update the specified media
     */
    public function update(Request $request, $id)
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบสื่อที่ต้องการ'
            ], 404);
        }

        // Check permission
        $user = $request->user();
        if ($media->teacher_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์แก้ไขสื่อนี้'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'media_type' => 'sometimes|required|in:video,document,image,audio,other',
            'category' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:524288', // 512MB max
            'status' => 'sometimes|required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'ข้อมูลไม่ถูกต้อง',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update basic fields
            $updateData = $request->only(['title', 'description', 'media_type', 'category', 'status']);
            
            // If new file uploaded
            if ($request->hasFile('file')) {
                // Delete old file
                Storage::disk('public')->delete($media->file_path);
                
                // Upload new file
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('media', $fileName, 'public');
                
                $updateData['file_path'] = $filePath;
                $updateData['file_name'] = $fileName;
                $updateData['file_type'] = $file->getClientMimeType();
                $updateData['file_size'] = $file->getSize();
            }

            $media->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'อัปเดทสื่อสำเร็จ',
                'data' => $media
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการอัปเดทสื่อ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified media
     */
    public function destroy(Request $request, $id)
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบสื่อที่ต้องการ'
            ], 404);
        }

        // Check permission
        $user = $request->user();
        if ($media->teacher_id !== $user->id && !$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'คุณไม่มีสิทธิ์ลบสื่อนี้'
            ], 403);
        }

        try {
            // Delete file from storage
            Storage::disk('public')->delete($media->file_path);
            
            // Delete record
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'ลบสื่อสำเร็จ'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการลบสื่อ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get media by category
     */
    public function getByCategory(Request $request, $category)
    {
        $user = $request->user();
        
        $query = Media::where('category', $category);
        
        // If not teacher/admin, show only published
        if (!$user->isTeacher() && !$user->isAdmin()) {
            $query->where('status', 'published');
        } else {
            $query->where('teacher_id', $user->id);
        }
        
        $media = $query->with('teacher:id,firstname,lastname,username')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $media
        ], 200);
    }

    /**
     * Get media by type
     */
    public function getByType(Request $request, $type)
    {
        $user = $request->user();
        
        $query = Media::where('media_type', $type);
        
        // If not teacher/admin, show only published
        if (!$user->isTeacher() && !$user->isAdmin()) {
            $query->where('status', 'published');
        } else {
            $query->where('teacher_id', $user->id);
        }
        
        $media = $query->with('teacher:id,firstname,lastname,username')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $media
        ], 200);
    }

    /**
     * Download media file
     */
    public function download(Request $request, $id)
    {
        $user = $request->user();
        $media = Media::find($id);

        if (!$media) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบสื่อที่ต้องการดาวน์โหลด'
            ], 404);
        }

        // Check permission: teachers can download their own media, students can download published media
        if (!$user->isTeacher() && !$user->isAdmin()) {
            if ($media->status !== 'published') {
                return response()->json([
                    'success' => false,
                    'message' => 'คุณไม่มีสิทธิ์ดาวน์โหลดสื่อนี้'
                ], 403);
            }
        } else {
            // Teachers can only download their own media
            if ($media->teacher_id !== $user->id && !$user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'คุณไม่มีสิทธิ์ดาวน์โหลดสื่อนี้'
                ], 403);
            }
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($media->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบไฟล์สื่อ'
            ], 404);
        }

        // Get file path and original filename
        $filePath = Storage::disk('public')->path($media->file_path);
        $fileName = $media->original_filename ?: basename($media->file_path);

        // Return file download response
        return response()->download($filePath, $fileName);
    }
}
