<?php

namespace App\Jobs;

use App\Models\Media;
use App\Services\VideoTranscodingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TranscodeVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Media $media
    ) {}

    /**
     * Execute the job.
     */
    public function handle(VideoTranscodingService $transcodingService): void
    {
        Log::info("Starting video transcoding job for media {$this->media->id}");

        try {
            $transcodingService->transcodeVideo($this->media);
            
            Log::info("Completed video transcoding job for media {$this->media->id}");
        } catch (\Exception $e) {
            Log::error("Video transcoding job failed for media {$this->media->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Video transcoding job permanently failed for media {$this->media->id}", [
            'error' => $exception->getMessage(),
        ]);
    }
}
