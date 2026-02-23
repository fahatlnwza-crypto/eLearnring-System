<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaQuality extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media_qualities';

    /**
     * Boot function for UUID generation
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'media_id',
        'quality_label',
        'file_path',
        'file_name',
        'file_size',
        'width',
        'height',
        'bitrate',
        'status',
        'error_message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['file_url'];

    /**
     * Get the media that owns this quality.
     */
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    /**
     * Get full file URL
     */
    public function getFileUrlAttribute(): string
    {
        // Split path into directory and filename, encode filename to handle spaces
        $pathParts = explode('/', $this->file_path);
        $fileName = array_pop($pathParts);
        $directory = implode('/', $pathParts);
        
        $encodedFileName = rawurlencode($fileName);
        $fullPath = $directory ? $directory . '/' . $encodedFileName : $encodedFileName;
        
        return url('storage/' . $fullPath);
    }

    /**
     * Check if quality is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if quality is processing
     */
    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    /**
     * Check if quality failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
