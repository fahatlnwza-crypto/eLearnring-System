<?php

namespace App\Services;

use App\Models\Media;
use App\Models\MediaQuality;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class VideoTranscodingService
{
    /**
     * Quality presets for video transcoding
     */
    protected array $qualityPresets = [
        '360p' => [
            'width' => 640,
            'height' => 360,
            'bitrate' => '800k',
            'audio_bitrate' => '96k',
        ],
        '480p' => [
            'width' => 854,
            'height' => 480,
            'bitrate' => '1200k',
            'audio_bitrate' => '128k',
        ],
        '720p' => [
            'width' => 1280,
            'height' => 720,
            'bitrate' => '2500k',
            'audio_bitrate' => '128k',
        ],
        '1080p' => [
            'width' => 1920,
            'height' => 1080,
            'bitrate' => '5000k',
            'audio_bitrate' => '192k',
        ],
    ];

    /**
     * Transcode video to multiple qualities
     */
    public function transcodeVideo(Media $media): void
    {
        if ($media->media_type !== 'video') {
            Log::warning("Media {$media->id} is not a video, skipping transcoding");
            return;
        }

        $originalPath = storage_path('app/public/' . $media->file_path);
        
        if (!file_exists($originalPath)) {
            Log::error("Original video file not found: {$originalPath}");
            return;
        }

        // Get original video dimensions
        $dimensions = $this->getVideoDimensions($originalPath);
        $originalHeight = $dimensions['height'];

        Log::info("Starting video transcoding for media {$media->id}", [
            'original_dimensions' => $dimensions
        ]);

        // Transcode to each quality that is smaller than or equal to original
        foreach ($this->qualityPresets as $qualityLabel => $preset) {
            if ($preset['height'] <= $originalHeight) {
                $this->transcodeToQuality($media, $originalPath, $qualityLabel, $preset);
            } else {
                Log::info("Skipping {$qualityLabel} as it's larger than original video");
            }
        }
    }

    /**
     * Transcode video to specific quality
     */
    protected function transcodeToQuality(Media $media, string $originalPath, string $qualityLabel, array $preset): void
    {
        try {
            // Create quality record
            $mediaQuality = MediaQuality::create([
                'media_id' => $media->id,
                'quality_label' => $qualityLabel,
                'file_path' => '',
                'file_name' => '',
                'file_size' => 0,
                'width' => $preset['width'],
                'height' => $preset['height'],
                'bitrate' => intval($preset['bitrate']),
                'status' => 'processing',
            ]);

            Log::info("Processing {$qualityLabel} for media {$media->id}");

            // Generate output filename
            $pathInfo = pathinfo($media->file_name);
            $outputFileName = $pathInfo['filename'] . "_{$qualityLabel}." . $pathInfo['extension'];
            $outputPath = storage_path('app/public/media/' . $outputFileName);

            // Build FFmpeg command
            $command = [
                'ffmpeg',
                '-i', $originalPath,
                '-vf', "scale={$preset['width']}:{$preset['height']}",
                '-c:v', 'libx264',
                '-preset', 'medium',
                '-crf', '23',
                '-b:v', $preset['bitrate'],
                '-c:a', 'aac',
                '-b:a', $preset['audio_bitrate'],
                '-movflags', '+faststart',
                '-y', // Overwrite output file
                $outputPath
            ];

            // Run FFmpeg process
            $process = new Process($command);
            $process->setTimeout(3600); // 1 hour timeout
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Update quality record with output file info
            $fileSize = filesize($outputPath);
            $mediaQuality->update([
                'file_path' => 'media/' . $outputFileName,
                'file_name' => $outputFileName,
                'file_size' => $fileSize,
                'status' => 'completed',
            ]);

            Log::info("Successfully transcoded {$qualityLabel} for media {$media->id}", [
                'output_file' => $outputFileName,
                'file_size' => $fileSize,
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to transcode {$qualityLabel} for media {$media->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if (isset($mediaQuality)) {
                $mediaQuality->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Get video dimensions using FFprobe
     */
    protected function getVideoDimensions(string $videoPath): array
    {
        $command = [
            'ffprobe',
            '-v', 'error',
            '-select_streams', 'v:0',
            '-show_entries', 'stream=width,height',
            '-of', 'csv=p=0',
            $videoPath
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = trim($process->getOutput());
        [$width, $height] = explode(',', $output);

        return [
            'width' => intval($width),
            'height' => intval($height),
        ];
    }

    /**
     * Delete all quality versions of a video
     */
    public function deleteVideoQualities(Media $media): void
    {
        $qualities = $media->mediaQualities;

        foreach ($qualities as $quality) {
            $filePath = storage_path('app/public/' . $quality->file_path);
            
            if (file_exists($filePath)) {
                unlink($filePath);
                Log::info("Deleted quality file: {$filePath}");
            }

            $quality->delete();
        }
    }
}
