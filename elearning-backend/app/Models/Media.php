<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

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
        'teacher_id',
        'title',
        'description',
        'media_type',
        'category',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'status',
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
    protected $appends = ['file_url', 'qualities'];

    /**
     * Get the teacher that owns the media.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the qualities for the media.
     */
    public function mediaQualities()
    {
        return $this->hasMany(MediaQuality::class, 'media_id');
    }

    /**
     * Check if media is published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if media is draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
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
     * Get available video qualities
     */
    public function getQualitiesAttribute(): array
    {
        if ($this->media_type !== 'video') {
            return [];
        }

        $qualities = $this->mediaQualities()
            ->where('status', 'completed')
            ->orderBy('height', 'desc')
            ->get()
            ->map(function ($quality) {
                return [
                    'label' => $quality->quality_label,
                    'url' => $quality->file_url,
                    'width' => $quality->width,
                    'height' => $quality->height,
                    'size' => $quality->file_size,
                ];
            })
            ->toArray();

        return $qualities;
    }
}
